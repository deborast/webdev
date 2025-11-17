<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    private $products;

    public function __construct()
    {
    //dummy
    $this->products = [
        ['id' => 1, 'name' => 'Caramel Latte', 'description' => 'Sweet caramel with steamed milk', 'price' => 38000],
        ['id' => 2, 'name' => 'Hazelnut Cappuccino', 'description' => 'Nutty flavor cappuccino', 'price' => 42000],
        ['id' => 3, 'name' => 'Mocha Delight', 'description' => 'Chocolate infused espresso', 'price' => 45000],
        ['id' => 4, 'name' => 'Cold Brew Classic', 'description' => 'Smooth 12-hour brew', 'price' => 35000],
        ['id' => 5, 'name' => 'Vanilla Sweet Cream Cold Brew', 'description' => 'Cold brew with a touch of vanilla cream', 'price' => 46000],
        ['id' => 6, 'name' => 'Irish Cream Latte', 'description' => 'Rich Irish cream with espresso', 'price' => 48000],
        ['id' => 7, 'name' => 'Americano Bold', 'description' => 'Strong espresso with hot water', 'price'=> 30000],
        ['id' => 8, 'name' => 'Flat White', 'description' => 'Smooth ristretto with steamed milk', 'price' => 42000],
        ['id' => 9, 'name' => 'Matcha Latte', 'description' => 'Premium Japanese matcha with milk', 'price' => 40000],
        ['id' => 10, 'name' => 'Brown Sugar Latte', 'description' => 'Espresso with brown sugar syrup', 'price' => 43000],
        ['id' => 11, 'name' => 'Cookies & Cream Frappe', 'description' => 'Blended frappe with cookie bits', 'price' => 48000],
        ['id' => 12, 'name' => 'Signature Chocolate', 'description' => 'Rich cocoa with steamed milk', 'price' => 38000],
        ['id' => 13, 'name' => 'Peppermint Mocha', 'description' => 'Mocha with refreshing peppermint', 'price' => 47000],
        ['id' => 14, 'name' => 'Spanish Latte', 'description' => 'Sweet condensed milk latte', 'price' => 45000],
        ['id' => 15, 'name' => 'Tiramisu Latte', 'description' => 'Espresso with tiramisu flavor', 'price' => 49000],
        ['id' => 16, 'name' => 'Honey Oat Latte', 'description' => 'Oat milk with natural honey', 'price' => 46000],
        ['id' => 17, 'name' => 'Berry Hibiscus Tea', 'description' => 'Refreshing tea with hibiscus & berries', 'price' => 35000],
        ['id' => 18, 'name' => 'Lemon Earl Grey Tea', 'description' => 'Citrus twist on classic Earl Grey', 'price' => 34000],
        ['id' => 19, 'name' => 'Mango Yakult Fizz', 'description' => 'Fizzy tropical mango with yakult', 'price' => 39000],
        ['id' => 20, 'name' => 'Strawberry Sweet Tea', 'description' => 'Cold tea with strawberry syrup', 'price' => 33000],
    ];
    }


    public function index()
    {
        $products = $this->products;
        return view('products.list', compact('products'));
    }

    public function create()
    {
        return view('products.form');
    }

    public function edit($id)
    {
        $product = collect($this->products)->firstWhere('id', $id);
        return view('products.form', compact('product'));
    }

    public function store(Request $request)
    {
        return redirect()->route('products.index')
            ->with('success', 'Product added (dummy, no DB)');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('products.index')
            ->with('success', 'Product updated (dummy, no DB)');
    }

    public function show($id)
    {
        $product = collect($this->products)->firstWhere('id', $id);
        return view('products.show', compact('product'));
    }
}
