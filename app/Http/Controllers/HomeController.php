<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function adminLanding()
    {
        $productCount = Product::count();
        $orderCount   = Order::count();
        $lowStock     = Product::where('stock', '<=', 5)->orderBy('stock')->take(5)->get();

        return view('admin.dashboard', compact('productCount', 'orderCount', 'lowStock'));
    }
}
