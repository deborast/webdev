<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
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
        $cart = Cart::with('items')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        $cart = Cart::with('items')
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
            $total = $cart->items->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            $order = Order::create([
                'user_id'          => Auth::id(),
                'shipping_address' => $shippingAddress,
                'payment_method'   => $validated['payment_method'],
                'total'            => $total,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'name'       => $item->name,
                    'price'      => $item->price,
                    'quantity'   => $item->quantity,
                    'subtotal'   => $item->quantity * $item->price,
                ]);
            }

            $cart->items()->delete();
        });

        return redirect()->route('orders.index')
            ->with('success', 'Checkout successful. Thank you for your purchase!');
    }
}
