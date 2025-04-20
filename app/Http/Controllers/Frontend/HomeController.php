<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('variation');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%$search%")->orWhere('sku', 'LIKE', "%$search%");
        }

        $products = $query->orderBy('id', 'desc')->paginate(12);
        return view('frontend.home', compact('products'));
    }
}
