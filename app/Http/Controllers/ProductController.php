<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

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

        $sortBy = $request->get('sort_by', 'name');
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

        $categories = Category::all();
        $currentCategoryId = $request->category_id;

        $cartItemsByProduct = [];
        if (Auth::check()) {
            $cart = Cart::with('items')
                ->where('user_id', Auth::id())
                ->first();

            if ($cart) {
                $cartItemsByProduct = $cart->items
                    ->pluck('quantity', 'product_id')
                    ->toArray();
            }
        }

        return view('products.list', compact(
            'products',
            'categories',
            'currentCategoryId',
            'cartItemsByProduct'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|integer|min:0',
        ]);

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
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|integer|min:0',
        ]);

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('products.show', compact('product'));
    }
}
