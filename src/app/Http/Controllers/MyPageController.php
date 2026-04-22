<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $products = $user->products;
        return view('mypage.index',compact('user','products'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('mypage.edit',compact('user','profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->name
        ]);

        $profileData = [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ];

        if($request->hasFile('image')){
            $profileData['profile_image'] = $request->file('image')->store('profiles','public');
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect('/mypage');
    }
}
