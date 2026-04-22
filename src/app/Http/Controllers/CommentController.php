<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request,$item_id)
    {
        $product = Product::findOrFail($item_id);

        $product->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return redirect('/item/' . $item_id);
    }
}
