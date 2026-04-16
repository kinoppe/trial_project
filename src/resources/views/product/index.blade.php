@extends('layouts.app')

@section('title')
商品一覧
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product/index.css')}}">
@endsection

@section('content')
<div class="product">
    <div class="tab-menu">
        <a class="tab-menu__item" href="">おすすめ</a>
        <a class="tab-menu__item--my-list" href="">マイリスト</a>
    </div>
    <div class="product__list">
        @foreach ($products as $product)
        <div class="product-card">
            <div class="product-card__image">
                <img src="{{asset('storage/' . $product->image)}}" alt="">
            </div>
            <p class="product-card__name">{{$product->name}}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection
