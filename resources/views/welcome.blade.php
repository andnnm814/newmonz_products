@extends('layouts.app')
@section('content')
<div class="welcome">
    @auth
    <a class="btn" href="{{ route('products.index') }}">商品一覧</a>
    @else
    <a class="btn" href="{{ route('register') }}">会員登録</a>
    <a class="btn" href="{{ route('login') }}">ログイン</a>
    @endauth
</div>
@endsection()