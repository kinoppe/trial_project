@extends('layouts.app')

@section('title')
プロフィール画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/mypage/index.css')}}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage-profile">
        <div class="mypage-profile-user">
            <div class="profile-image">
                @if($user->profile && $user->profile->profile_image)
                <img src="{{asset('storage/' . $user->profile->profile_image)}}">
                @endif
            </div>
            <h1 class="profile-name">{{$user->name}}</h1>
        </div>
        <a class="profile-edit" href="/mypage/profile">プロフィールを編集</a>
    </div>

    <div class="mypage-tabs">
        <a class="mypage-tab {{request('page') !== 'buy' ? 'mypage-tab--active' : ''}}"
        href="/mypage?page=sell">出品した商品</a>

        <a class="mypage-tab {{request('page') === 'buy' ? 'mypage-tab--active' : ''}}"
        href="/mypage?page=buy">購入した商品</a>
    </div>

    <div class="mypage__content">
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
</div>
@endsection