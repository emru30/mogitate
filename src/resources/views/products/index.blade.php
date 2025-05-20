@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection
@section('content')
<div class="container">
    <h1>商品一覧</h1>
    <a class="add-button" href="{{ route('products.register') }}">+商品を追加</a>

    <div class="flex-container">
        <aside class="sidebar">
            <form method="get" action="{{ route('products.search') }}">
                <input type="text" name="keyword" placeholder="商品名で検索" value="{{  old('keyword', $keyword) }}">

                <button type="submit">検索</button>

                <p class="select-title">価格順で表示</p>

                <select name="sort" class="{{ $order ? 'sort-active' : '' }}" onchange="this.form.submit()">
                    <option value="" @selected($order==='')>価格で並び替え</option>
                    <option value="high" @selected($order==='high')>高い順に表示</option>
                    <option value="low" @selected($order==='low')>低い順に表示</option>
                </select>
            </form>

            @if($order)
            <div class="tag">
                {{ $order==='high' ? '高い順に表示' : '低い順に表示' }}
                <a href="{{ route('products.search', array_filter(['keyword'=>$keyword])) }}">×</a>
            </div>
            @endif
        </aside>

        <div class="product-area">
            <div class="product-grid">
                @foreach ($products as $product)
                    <a class="product-card" href="{{ route('products.show', $product->id) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        <h2>{{ $product->name }}</h2>
                        <p>¥{{ number_format($product->price) }}</p>
                    </a>
                @endforeach
            </div>

            <nav class="pagination-wrapper">
            {{ $products->links('vendor.pagination.custom') }}
        </nav>
        </div>
    </div>
</div>
@endsection