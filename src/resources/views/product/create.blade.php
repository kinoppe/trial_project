@extends('layouts.app')

@section('title')
商品出品
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product/create.css')}}">
@endsection

@section('nav')
<a class="logout__link" href="/auth.logout">ログアウト</a>
@endsection

@section('content')
<div class="sell__content">
    <div class="sell__heading">
        <h1>商品の出品</h1>
    </div>

    <form class="sell-form" action="/sell" method="post" enctype="multipart/form-data">
        @csrf
        <div class="sell-form__group">
            <div class="sell-form__title">商品画像</div>
            <label class="sell-form__image-box">
                <input class="sell-form__file" type="file" name="image" hidden>
                <span class="sell-form__image-button">画像を選択する</span>
            </label>
            <div class="form__error">
                @error('image')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品の詳細</h2>
        </div>

        <div class="sell-form__group">
            <div class="sell-form__title">カテゴリー</div>
            <div class="sell-form__tags">
                @foreach($categories as $category)
                    <label class="sell-form__tag">
                        <input type="checkbox" name="categories[]" value="{{$category->id}}"
                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                        <span>{{$category->name}}</span>
                    </label>
                @endforeach
            </div>
            <div class="form__error">
                @error('categories')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="sell-form__group">
            <div class="sell-form__title">商品の状態</div>
            <select class="sell-form__select" name="condition">
                <option selected disabled>選択してください</option>
                <option value="良好"
                {{old('condition') == '良好' ? 'selected' : ''}}>良好</option>
                <option value="目立った傷や汚れなし"
                {{old('condition') == '目立った傷や汚れなし' ? 'selected' : ''}}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり"
                {{old('condition') == 'やや傷や汚れあり' ? 'selected' : ''}}>やや傷や汚れあり</option>
                <option value="状態が悪い"
                {{old('condition') == '状態が悪い' ? 'selected' : ''}}>状態が悪い</option>
            </select>
            <div class="form__error">
                @error('condition')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品名と説明</h2>
        </div>

        <div class="sell-form__group">
            <div class="sell-form__title">商品名</div>
            <input class="sell-form__input" type="text" name="name" value="{{old('name')}}">
            <div class="form__error">
                @error('name')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="sell-form__group">
            <div class="sell-form__title">ブランド名</div>
            <input class="sell-form__input" type="text" name="brand_name" value="{{old('brand_name')}}">
        </div>

        <div class="sell-form__group">
            <div class="sell-form__title">商品の説明</div>
            <textarea class="sell-form__textarea" name="description">{{old('description')}}</textarea>
            <div class="form__error">
                @error('description')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="sell-form__group">
            <div class="sell-form__title">販売価格</div>
            <input class="sell-form__input" type="text" name="price" value="{{old('price')}}" placeholder="¥">
            <div class="form__error">
                @error('price')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="sell-form__submit">
            <button class="sell-form__submit-button" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection
