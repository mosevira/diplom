<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $totalPrice = Product::sum('price'); // Сумма всех цен
        $products = Product::all(); // Все продукты для графиков (если нужно)

        return view('seller.dashboard', compact('productsCount', 'totalPrice', 'products'));
    }
}
