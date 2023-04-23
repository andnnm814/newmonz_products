@extends('layouts.app')
@section('content')
<h1>商品編集</h1>

<form action="{{ route('products.update', $product) }}" method="post">
    @csrf
    @method('patch')
    <table>
    <tr>
        <td>ID</td>
        <td>{{ $product->id }}</td>
    </tr>
    <tr>
        <td>カテゴリ</td>
        <td>
            <select name="category_id" class="form-select">
                <option value="{{ $product->category->id }}" hidden>{{ $product->category->name }}</option>
                @foreach (App\Models\Category::all() as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td>メーカー</td>
        <td><input type="text" name="maker" value="{{ old('maker', $product->maker) }}"></td>
    </tr>
    <tr>
        <td>商品名</td>
        <td><input type="text" name="name" value="{{ old('name', $product->name) }}"></td>
    </tr>
    <tr>
        <td>価格</td>
        <td><input type="text" name="price" value="{{ old('price', $product->price) }}"></td>
    </tr>
    <tr>
        <td>登録日</td>
        <td>{{ Carbon\Carbon::parse($product->created_at)->format('Y年m月d日') }}</td>
    </tr>
</table>
<button type="submit">更新する</button>
<a href="{{ route('products.show', $product) }}">キャンセル</a>
</form>
@endsection()