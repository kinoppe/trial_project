<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;


class PurchaseController extends Controller
{
    public function create($item_id)
    {
        $product = Product::findOrFail($item_id);
        $profile = Auth::user()->profile;
        $address = session('purchase_address.' . $item_id, [
            'postal_code' => optional($profile)->postal_code,
            'address' => optional($profile)->address,
            'building' => optional($profile)->building
        ]);
        return view('purchase.create',compact('product','address'));
    }

    public function store(PurchaseRequest $request,$item_id)
    {
        $product = Product::findOrFail($item_id);
        $address = session('purchase_address.' . $item_id);
        if(!$address) {
            $profile = Auth::user()->profile;
            $address = [
                'postal_code' => optional($profile)->postal_code,
                'address' => optional($profile)->address,
                'building' => optional($profile)->building
            ];
        }
        Purchase::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'payment_method' => $request->payment_method,
            'postal_code' => $address['postal_code'],
            'address' => $address['address'],
            'building' => $address['building']
        ]);
        session()->forget('purchase_address.' . $item_id);

        return redirect('/');
    }

    public function edit($item_id)
    {
        $product = Product::findOrFail($item_id);
        $profile = Auth::user()->profile;
        $address = session('purchase_address.' . $item_id, [
            'postal_code' => optional($profile)->postal_code,
            'address' => optional($profile)->address,
            'building' => optional($profile)->building
        ]);
        return view('purchase.edit',compact('product','address'));
    }

    public function update(AddressRequest $request,$item_id)
    {
        session([
            'purchase_address.' . $item_id => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building
            ]
        ]);
        return redirect('/purchase/' . $item_id);
    }
}
