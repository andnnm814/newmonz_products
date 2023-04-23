@extends('layouts.app')
@section('content')
<h1>商品詳細画面</h1>
<table>
    <tr>
        <td>ID</td>
        <td>{{ $product->id }}</td>
    </tr>
    <tr>
        <td>カテゴリ</td>
        <td>
            {{ $product->category->name }}
        </td>
    </tr>
    <tr>
        <td>メーカー</td>
        <td>{{ $product->maker }}</td>
    </tr>
    <tr>
        <td>商品名</td>
        <td>{{ $product->name }}</td>
    </tr>
    <tr>
        <td>価格</td>
        <td>{{ $product->price }}</td>
    </tr>
    <tr>
        <td>登録日</td>
        <td>{{ Carbon\Carbon::parse($product->created_at)->format('Y年m月d日') }}</td>
    </tr>
</table>
<div>
    <a href="{{ route('products.edit', $product) }}">編集</a>
    <a href="{{ route('products.index') }}">戻る</a>
    <form onsubmit="return confirm('本当に削除しますか？')" action="{{ route('products.destroy', $product) }}" method="post">
    @csrf
    @method('delete')
    <button type="submit">削除</button>
    </form>
</div>
@endsection()