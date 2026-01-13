<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function showCheckoutForm()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $addresses = ShippingAddress::where('user_id', Auth::id())->get();

        return view('orders.checkout', compact('cart', 'addresses'));
    }

    public function processCheckout(Request $request)
    {
        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'phone'          => 'required|string|max:30',
            'address_line'   => 'required|string|max:255',
            'province'       => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'payment_method' => 'required|string|max:100',
            'use_points'     => 'nullable|integer|min:0',

        ]);

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $shippingAddress = $validated['full_name'] . "\n"
            . $validated['address_line'] . "\n"
            . $validated['city'] . ", " . $validated['province'] . " " . $validated['postal_code'] . "\n"
            . "Phone: " . $validated['phone'];

        DB::transaction(function () use ($cart, $shippingAddress, $validated) {

            $user = Auth::user();

            // total awal + cek stok
            $total = 0;

            foreach ($cart->items as $item) {
                $product = $item->product;

                if (! $product) {
                    throw new \Exception('Product not found for cart item.');
                }

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                $total += $item->quantity * $item->price;
            }

            // bwt redeem points
            $requestedPoints = (int) ($validated['use_points'] ?? 0);
            $usePoints = min($requestedPoints, $user->loyalty_points);

            $discountPer100 = 10000;
            $discount = intdiv($usePoints, 100) * $discountPer100;

            if ($discount > $total) {
                $discount = $total;
            }

            $finalTotal = $total - $discount;

            // bwt ordr + smpn info poinny
            $order = Order::create([
                'user_id'                   => $user->id,
                'shipping_address'          => $shippingAddress,
                'payment_method'            => $validated['payment_method'],
                'total'                     => $finalTotal,
                'points_used'               => $usePoints,
                'subtotal_before_discount'  => $total,
            ]);

            // bwt item n minuz stox
            foreach ($cart->items as $item) {
                $product = $item->product;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'name'       => $item->name,
                    'price'      => $item->price,
                    'quantity'   => $item->quantity,
                    'subtotal'   => $item->quantity * $item->price,
                ]);

                $product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();

            // apadet poin user
            if ($usePoints > 0) {
                $user->loyalty_points -= $usePoints;
            }

            $earnedPoints = intdiv($finalTotal, 10000);
            if ($earnedPoints > 0) {
                $user->loyalty_points += $earnedPoints;
            }

            $user->save();
        });

        return redirect()->route('orders.index')
            ->with('success', 'Checkout successful. Thank you for your purchase!');
    }
}
