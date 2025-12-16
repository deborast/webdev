<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load('items.product');

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $qty = (int) $request->input('quantity', 1);

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            if ($qty <= 0) {
                $item->delete();
            } else {
                $item->update(['quantity' => $qty]);
            }
        } else {
            if ($qty > 0) {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'price'      => $product->price,
                    'quantity'   => $qty,
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Product added to cart');
    }

    public function update(Request $request, $itemId)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::findOrFail($itemId);

        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->update(['quantity' => $data['quantity']]);

        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    public function remove($itemId)
    {
        $item = CartItem::findOrFail($itemId);

        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart');
    }
}
