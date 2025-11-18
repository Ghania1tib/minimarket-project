<?php
// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
        }
        
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(12);
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::where('category', $product->category)
                                 ->where('id', '!=', $product->id)
                                 ->limit(4)
                                 ->get();
                                 
        return view('products.show', compact('product', 'relatedProducts'));
    }
}