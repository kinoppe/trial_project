<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img src="{{ asset('storage/icons/CoachTech_White 1 (1).png') }}">
            </a>
            <div class="header__search">
                <form class="search-form" action="/products/search" method="get">
                    <input class="search-form__input" type="text" name="keyword" placeholder="なにをお探しですか？">
                </form>
            </div>
            <nav class="header__nav">
                @auth
                <form action="/logout" method="post">
                    @csrf
                    <button class="logout__link">ログアウト</button>
                </form>
                @endauth

                @guest
                <a class="login__link "href="/login">ログイン</a>
                @endguest
                <a class="mypage__link" href="/mypage">マイページ</a>
                <a class="sell__button" href="/sell">出品</a>
            </nav>
        </div>
        
    </header>
    <main>
    @yield('content')
    </main>
</body>
</html>