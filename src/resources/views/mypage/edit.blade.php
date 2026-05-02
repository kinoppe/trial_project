@extends('layouts.app')

@section('title')
プロフィール設定
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/mypage/edit.css')}}">
@endsection

@section('content')
<div class="profile-form__content">
    <div class="profile-form__heading">
        <h1>プロフィール設定</h1>
    </div>
    <form class="form" action="/mypage/profile" method="post" enctype="multipart/form-data">
        @csrf
        <div class="profile-form__image-area">
            <div class="profile-form__image">
                <img id="preview" src="{{ optional($profile)->profile_image 
                ? asset('storage/' . $profile->profile_image) : asset('images/default-user.png') }}">
            </div>
            <div class="profile-form__image-button">
                <label class="image-select" for="image">画像を選択する</label>
                <input type="file" name="image" id="image" hidden>
            </div>
            <div class="form__error">
                @error('profile_image')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="profile-form__group">
            <div class="profile-form__group-title">
                <label for="name"><span class="form__label--item">ユーザー名</span></label>
            </div>
            <div class="profile-form-group__content">
                <div class="profile-form__input--text">
                    <input type="text" name="name" id="name" value="{{old('name',$user->name)}}">
                </div>
            </div>
            <div class="form__error">
                @error('name')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="profile-form__group">
            <div class="profile-form__group-title">
                <label for="postal_code"><span class="form__label--item">郵便番号</span></label>
            </div>
            <div class="profile-form-group__content">
                <div class="profile-form__input--text">
                    <input type="text" name="postal_code" id="postal_code" value="{{old('postal_code',optional($profile)->postal_code)}}">
                </div>
            </div>
            <div class="form__error">
                @error('postal_code')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="profile-form__group">
            <div class="profile-form__group-title">
                <label for="address"><span class="form__label--item">住所</span></label>
            </div>
            <div class="profile-form-group__content">
                <div class="profile-form__input--text">
                    <input type="text" name="address" id="address" value="{{old('address',optional($profile)->address)}}">
                </div>
            </div>
        </div>

        <div class="profile-form__group">
            <div class="profile-form__group-title">
                <label for="building"><span class="form__label--item">建物名</span></label>
            </div>
            <div class="profile-form-group__content">
                <div class="profile-form__input--text">
                    <input type="text" name="building" id="building" value="{{old('building',optional($profile)->building)}}">
                </div>
            </div>
        </div>

        <div class="profile-form__button">
            <button class="profile-form__button-submit" type="submit">更新する</button>
        </div>
    </form>
    <script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    });
    </script>
</div>
@endsection