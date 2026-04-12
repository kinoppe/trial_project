@extends('layouts.app')

@section('title')
商品一覧
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product/index.css')}}">
@endsection

@section('nav')
<a class="login__link" href="/auth.login">ログイン</a>
@endsection

@section('content')
<div class="product__content">
    <div class="tab-menu">
        <a class="tab-menu__item" href="">おすすめ</a>
        <a class="tab-menu__item--my-list"href="">マイリスト</a>
    </div>
    <div class="product__list">
        
    </div>

</div>
@endsection
