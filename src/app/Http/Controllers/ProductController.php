<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index',compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create',compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        return redirect('/');
    }
}
