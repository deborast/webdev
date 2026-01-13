<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function categories()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.categories', compact('categories'));
    }

    public function index(Request $request)
    {
        $query = Product::with('category')
            ->withSum('orderItems', 'quantity');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sortBy  = $request->get('sort_by', 'name');
        $sortDir = $request->get('sort_dir', 'asc');

        if (! in_array($sortBy, ['name', 'price'])) {
            $sortBy = 'name';
        }
        if (! in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'asc';
        }

        $products = $query
            ->orderBy($sortBy, $sortDir)
            ->paginate(12)
            ->withQueryString();

        $categories        = Category::all();
        $currentCategoryId = $request->category_id;

        $cartItemsByProduct = [];
        $wishlistProductIds = [];

        if (Auth::check()) {
            $cart = Cart::with('items')
                ->where('user_id', Auth::id())
                ->first();

            if ($cart) {
                $cartItemsByProduct = $cart->items
                    ->pluck('quantity', 'product_id')
                    ->toArray();
            }

            $wishlistProductIds = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        // rikomen produk
        $recommendedProducts = collect();

        if (Auth::check()) {
            // produk yg srg dibeli user
            $recommendedProducts = OrderItem::select('product_id')
                ->whereHas('order', function ($q) {
                    $q->where('user_id', Auth::id());
                })
                ->groupBy('product_id')
                ->orderByRaw('SUM(quantity) DESC')
                ->with('product.category')
                ->take(4)
                ->get()
                ->map(function ($item) {
                    return $item->product;
                })
                ->filter()
                ->unique('id');
        }

        // terlaris global
        if ($recommendedProducts->isEmpty()) {
            $recommendedProducts = Product::with('category')
                ->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->select('products.*')
                ->groupBy('products.id')
                ->orderByRaw('SUM(order_items.quantity) DESC')
                ->take(4)
                ->get();
        }

        // cm nampilin yang stoknya masih ada
        $recommendedProducts = $recommendedProducts->where('stock', '>', 0);

        return view('products.list', compact(
            'products',
            'categories',
            'currentCategoryId',
            'cartItemsByProduct',
            'wishlistProductIds',
            'recommendedProducts'
        ));
    }

    // anuanuan produx
    public function create()
    {
        $categories = Category::all();

        return view('products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'required|integer|min:0',
            'stock'            => 'required|integer|min:0',
            'discount_percent' => 'required|integer|min:0|max:100',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully');
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.form', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'required|integer|min:0',
            'stock'            => 'required|integer|min:0',
            'discount_percent' => 'required|integer|min:0|max:100',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $qtyInCart = 0;

        if (auth()->check()) {
            $cart = Cart::with('items')
                ->where('user_id', auth()->id())
                ->first();

            if ($cart) {
                $item      = $cart->items->firstWhere('product_id', $product->id);
                $qtyInCart = $item?->quantity ?? 0;
            }
        }

        return view('products.show', compact('product', 'qtyInCart'));
    }

    // buynow
    public function buyNow(Product $product)
    {
        $addresses = ShippingAddress::where('user_id', Auth::id())->get();

        $basePrice = $product->price;
        if ($product->discount_percent > 0) {
            $basePrice = $basePrice - intval($basePrice * $product->discount_percent / 100);
        }

        return view('products.buy_now', [
            'product'    => $product,
            'addresses'  => $addresses,
            'basePrice'  => $basePrice,
        ]);
    }

    // buynow with pointzy
    public function buyNowProcess(Request $request, Product $product)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'phone'          => 'required|string|max:30',
            'address_line'   => 'required|string|max:255',
            'province'       => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'payment_method' => 'required|string|max:100',
            'quantity'       => 'required|integer|min:1',
            'use_points'     => 'nullable|integer|min:0',
        ]);

        $qty = $validated['quantity'];

        if ($product->stock < $qty) {
            return back()->with('error', 'Insufficient stock for this product.');
        }

        $shippingAddress = $validated['full_name'] . "\n"
            . $validated['address_line'] . "\n"
            . $validated['city'] . ', ' . $validated['province'] . ' ' . $validated['postal_code'] . "\n"
            . 'Phone: ' . $validated['phone'];

        DB::transaction(function () use ($product, $validated, $shippingAddress, $qty) {

            $user = Auth::user();

            // harga dasar setelah diskon produk
            $basePrice = $product->price;
            if ($product->discount_percent > 0) {
                $basePrice = $basePrice - intval($basePrice * $product->discount_percent / 100);
            }

            $total = $qty * $basePrice;

            // reedem point tp untuk buynow
            $requestedPoints = (int) ($validated['use_points'] ?? 0);
            $usePoints       = min($requestedPoints, $user->loyalty_points);

            $discountPer100 = 10000;
            $discount       = intdiv($usePoints, 100) * $discountPer100;

            if ($discount > $total) {
                $discount = $total;
            }

            $finalTotal = $total - $discount;

            // buat order
            $order = Order::create([
                'user_id'          => $user->id,
                'shipping_address' => $shippingAddress,
                'payment_method'   => $validated['payment_method'],
                'total'            => $finalTotal,
            ]);

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $basePrice,   // harga setelah diskon produk
                'quantity'   => $qty,
                'subtotal'   => $total,       // sebelum potongan poin
            ]);

            $product->decrement('stock', $qty);

            // apdet poin
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
            ->with('success', 'Order placed successfully via Buy Now.');
            }

    public function promo()
    {
        $promoProducts = Product::where('discount_percent', '>', 0)->get();

        return view('promo', compact('promoProducts'));
    }


}
