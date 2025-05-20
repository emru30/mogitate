@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection
@section('content')
<div class="container">
    <p class="breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a> ＞ {{ $product->name }}
    </p>


    <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf

    <div class="form-top">
        <div class="image-upload">
            <label>商品画像</label>
            <input type="file" name="image" accept="image/png,image/jpeg">
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
            <div class="preview">
                <img src="{{ asset('storage/'.$product->image) }}" alt="">
            </div>
        </div>

        <div class="product-info">
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror

            <label>値段</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror

            <label>季節</label>
            <div class="season-options">
            @foreach ($seasons as $season)
                <label>
                    <input type="checkbox" name="season[]" value="{{ $season->id }}" {{ in_array($season->id, old('season', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                    {{ $season->name }}
                </label>
            @endforeach

            </div>
            @error('season_id')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="description-area">
        <label>商品説明</label>
        <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-buttons">
        <a href="{{ route('products.index') }}">戻る</a>
        <button type="submit">変更を保存</button>
    </div>
</form>


    <form method="post" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('削除しますか？')" class="trash-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="trash-btn">🗑️</button>
    </form>
</div>
@endsection
