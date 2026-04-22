@extends('layouts.app')

@section('title')
商品詳細
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product/show.css')}}">
@endsection

@section('content')
<div class="product-detail">
    <div class="product-detail__image-box">
        <img class="product-detail__image" src="{{asset('storage/' . $product->image)}}">
    </div>

    <div class="product-detail__content">
        <h1 class="product-detail__name">{{$product->name}}</h1>
        <p class="product-detail__brand">{{$product->brand_name}}</p>
        <p class="product-detail__price"><span class="price-item">¥</span>{{number_format($product->price)}} <span class="price-item">(税込)</span></p>

        <div class="product-detail__actions">
            <div class="product-detail__icons">
                <div class="product-detail__icon">
                    <button class="product-detail__icon-button" type="button">🤍</button>
                    <span class="product-detail__icons-count">{{$product->likes()->count()}}</span>
                </div>
                <div class="product-detail__icon">
                    <button class="product-detail__icon-button" type="button">💬</button>
                    <span class="product-detail__icons-count">{{$product->comments()->count()}}</span>
                </div>
            </div>

            <a class="product-detail__purchase-button" href="">購入手続きへ</a>
        </div>

        <div class="product-detail__group">
            <h2>商品説明</h2>
            <p class="product-detail__description">{{$product->description}}</p>
        </div>

        <div class="product-detail__group">
            <h2>商品の情報</h2>
            <div class="product-detail__info-row">
                <span class="product-detail__label">カテゴリー</span>
                <div class="product-detail__categories">
                    @foreach ($product->categories as $category)
                        <span class="product-detail__category-tag">{{$category->name}}</span>
                    @endforeach
                </div>
            </div>

            <div class="product-detail__info-row">
                <span class="product-detail__label">商品の状態</span>
                <span class="product-detail__value">{{ $product->condition }}</span>
            </div>
        </div>

        <div class="product-detail__group">
            <h2>コメント({{ $product->comments->count() }})</h2>

            @foreach ($product->comments as $comment)
                <div class="product-detail__comment">
                    <div class="product-detail__comment-header">
                        <div class="product-detail__comment-user-image">
                            @if ($comment->user->profile && $comment->user->profile->image)
                                <img src="{{ asset('storage/' . $comment->user->profile->image) }}" alt="{{ $comment->user->name }}">
                            @else
                                <div class="product-detail__comment-user-not-image"></div>
                            @endif
                        </div>
                        <span class="product-detail__comment-user-name">{{ $comment->user->name }}</span>
                    </div>
                    <p class="product-detail__comment-body">{{ $comment->content }}</p>
                </div>
            @endforeach
        </div>

        <div class="product-detail__group">
            <h2>商品へのコメント</h2>

            <form action="{{route('comment.store',['item_id' => $product->id])}}" method="post">
                @csrf
                <textarea class="product-detail__textarea" name="content" rows="6">{{ old('content') }}</textarea>
                <div class="form__error">
                    @error('content')
                        {{ $message }}
                    @enderror
                </div>

                <button class="product-detail__comment-button" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection