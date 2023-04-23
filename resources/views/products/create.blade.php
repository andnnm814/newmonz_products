@extends('layouts.app')
@section('content')
<h1>商品登録</h1>

<form action="{{ route('products.store') }}" method="post">
    @csrf
    <table>
        <tr>
            <td>カテゴリ</td>
            <td>
                <select name="category_id" class="form-select">
                    <option value="" hidden>選択してください</option>
                    @foreach (App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>メーカー</td>
            <td><input type="text" name="maker" value="{{ old('maker') }}"></td>
        </tr>
        <tr>
            <td>商品名</td>
            <td><input type="text" name="name" value="{{ old('name') }}"></td>
        </tr>
        <tr>
            <td>価格</td>
            <td><input type="text" name="price" value="{{ old('price') }}"></td>
        </tr>
    </table>

    <button type="submit">登録する</button>
    <a href="{{ route('products.index') }}">キャンセル</a>
</form>
@endsection()