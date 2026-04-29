@extends('layouts.app')

@section('title')
住所変更
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase/edit.css')}}">
@endsection

@section('content')
<div class="address-form__content">
    <div class="address-form__heading">
        <h1>住所の変更</h1>
    </div>
    <form class="form" action="" method="post">
        @csrf
        <div class="address-form__group">
            <div class="address-form__group-title">
                <label for="postal_code"><span class="form__label--item">郵便番号</span></label>
            </div>
            <div class="address-form-group__content">
                <div class="address-form__input--text">
                    <input type="text" name="postal_code" id="postal_code" value="{{old('postal_code',$address['postal_code'] ?? '')}}">
                </div>
            </div>
            <div class="form__error">
                @error('postal_code')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="address-form__group">
            <div class="address-form__group-title">
                <label for="address"><span class="form__label--item">住所</span></label>
            </div>
            <div class="address-form-group__content">
                <div class="address-form__input--text">
                    <input type="text" name="address" id="address" value="{{old('address',$address['address'] ?? '')}}">
                </div>
            </div>
            <div class="form__error">
                @error('address')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="address-form__group">
            <div class="address-form__group-title">
                <label for="building"><span class="form__label--item">建物名</span></label>
            </div>
            <div class="address-form-group__content">
                <div class="address-form__input--text">
                    <input type="text" name="building" id="building" value="{{old('building',$address['building'] ?? '')}}">
                </div>
            </div>
        </div>

        <div class="address-form__button">
            <button class="address-form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection