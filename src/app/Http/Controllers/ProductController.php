<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index',compact('products'));
    }

    public function show($product_id)
    {
        $product = Product::with(['categories','comments.user','likes'])->findOrFail($product_id);
        return view('product.show',compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create',compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->only([
            'name',
            'brand_name',
            'description',
            'condition',
            'price'
        ]);

        $data['user_id'] = Auth::id();

        $data['image'] = $request->file('image')->store('products','public');

        $product = Product::create($data);

        $product->categories()->sync($request->categories);
        return redirect('/');
    }
}
