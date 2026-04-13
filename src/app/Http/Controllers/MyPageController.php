<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function edit()
    {
        return view('mypage.edit');
    }
}
