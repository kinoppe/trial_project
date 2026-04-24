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
        <a class="tab-menu__item {{request('tab') !== 'mylist' ? 'tab-menu__item--active' : ''}}" href="/">おすすめ</a>
        <a class="tab-menu__item {{request('tab') === 'mylist' ? 'tab-menu__item--active' : ''}}" href="/?tab=mylist">マイリスト</a>
    </div>
    <div class="product__list">
        @foreach ($products as $product)
        <a class="product-card" href="{{url('/item/' . $product->id)}}">
            <div class="product-card__image-box">
                <img class="product-card__image" src="{{asset('storage/' . $product->image)}}" alt="">
            </div>
            <p class="product-card__name">{{$product->name}}</p>
        </a>
        @endforeach
    </div>
</div>
@endsection
