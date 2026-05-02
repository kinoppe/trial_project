@extends('layouts.app')

@section('title')
商品購入
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase/create.css')}}">
@endsection

@section('content')
<div class="purchase">
    <div class="purchase-left">
        <div class="product">
            <div class="product__image">
                <img src="{{asset('storage/' . $product->image)}}" alt="">
            </div>
            <div class="product-info">
                <h1 class="product__name">{{$product->name}}</h1>
                <p class="product__price">¥ {{number_format($product->price)}}</p>
            </div>
        </div>
        <form class="purchase-form" action="/purchase/{{$product->id}}" method="post" id="purchase-form">
            @csrf

            <input type="hidden" name="postal_code" value="{{ $address['postal_code'] ?? '' }}">
            <input type="hidden" name="address" value="{{ $address['address'] ?? '' }}">
            <input type="hidden" name="building" value="{{ $address['building'] ?? '' }}">

            <div class="purchase-group">
                <p class="purchase-group__title">支払い方法</p>
                <select class="purchase-form__select" name="payment_method" id="payment-method">
                    <option selected disabled>選択してください</option>
                    <option value="1">コンビニ払い</option>
                    <option value="2">カード支払い</option>
                </select>
                <div class="form__error">
                    @error('payment_method')
                    {{$message}}
                    @enderror
                </div>
            </div>

            <div class="purchase-group">
                <div class="purchase-delivery">
                    <p class="purchase-group__title">配送先</p>
                    <a class="purchase-change__link" href="/purchase/address/{{$product->id}}">変更する</a>
                </div>
                <div class="purchase-address">
                    <p>〒 {{$address['postal_code']}}</p>
                    <p>{{$address['address']}} {{$address['building']}}</p>
                </div>
                <div class="form__error">
                    @error('postal_code')
                    {{$message}}
                    @enderror
                    @error('address')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </form>
    </div>

    <div class="purchase-right">
        <div class="purchase-confirm">
            <div class="purchase-confirm__row">
                <span class="purchase-confirm__title">商品代金</span>
                <span>¥ {{number_format($product->price)}}</span>
            </div>
            <div class="purchase-confirm__row">
                <span class="purchase-confirm__title">支払い方法</span>
                <span id="selected-payment">選択してください</span>
            </div>
        </div>
        <button class="purchase-button" type="submit" form="purchase-form">購入する</button>
    </div>
</div>
<script>
    const select = document.getElementById('payment-method');
    const display = document.getElementById('selected-payment');

    select.addEventListener('change', function () {
        if (this.value === '1') {
            display.textContent = 'コンビニ支払い';
        } else if (this.value === '2') {
            display.textContent = 'カード支払い';
        } else {
            display.textContent = '選択してください';
        }
    });
</script>
@endsection