<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($item_id)
    {
        $product = Product::findOrFail($item_id);

        $alreadyLiked = $product->likes()->where('user_id', Auth::id())->exists();

        if(! $alreadyLiked) {
            $product->likes()->create([
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->back();
    }

    public function destroy($item_id)
    {
        $product = Product::findOrFail($item_id);

        $product->likes()
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back();
    }
}
