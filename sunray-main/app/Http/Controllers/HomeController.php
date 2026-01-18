<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) : View
    {
        
        $featuredProducts = Product::where('is_featured', true)->limit(3)->get();

        $productsOnSale = Product::where('on_sale', true)->limit(3)->get();

        return view('home', compact('featuredProducts', 'productsOnSale'));

    }
}
