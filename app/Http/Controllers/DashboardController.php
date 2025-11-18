<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        // Get products with search filter
        $products = Product::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
        })->get();

        // Get unique categories
        $categories = Product::select('category')->distinct()->pluck('category');
        
        // Flash sale products (last 4 products as example)
        $flashSaleProducts = Product::where('is_flash_sale', true)
                                   ->orWhere('discount_percent', '>', 0)
                                   ->limit(4)
                                   ->get();

        // Special products
        $specialProducts = Product::where('is_special', true)
                                 ->orWhere('rating', '>=', 4.5)
                                 ->limit(6)
                                 ->get();

        // Popular products (based on sold_count)
        $popularProducts = Product::orderBy('sold_count', 'desc')
                                 ->limit(8)
                                 ->get();

        // New arrivals
        $newProducts = Product::orderBy('created_at', 'desc')
                             ->limit(6)
                             ->get();

        $cartCount = auth()->check() ? Cart::where('user_id', auth()->id())->count() : 0;

        return view('dashboard.index', compact(
            'products', 
            'categories', 
            'flashSaleProducts',
            'specialProducts',
            'popularProducts',
            'newProducts',
            'search',
            'cartCount'
        ));
    }
}