<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [ProductController::class,'index']);
Route::get('/item/{item_id}', [ProductController::class,'show']);
Route::middleware('auth')->group(function () {
    Route::get('/sell', [ProductController::class,'create']);
    Route::post('/sell', [ProductController::class,'store']);
    Route::get('/mypage', [MyPageController::class,'index']);
    Route::get('/mypage/profile', [MyPageController::class,'edit']);
    Route::post('/mypage/profile', [MyPageController::class,'update']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create'])
    ->name('purchase.create');
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])
    ->name('comment.store');
});

