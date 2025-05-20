@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection
@section('content')
<div class="product-register">
    <h2>商品登録</h2>

    <form class="product-form" action="{{ route('products.register.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">商品名 <span class="required">必須</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">値段 <span class="required">必須</span></label>
            <input type="text" name="price" id="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">商品画像 <span class="required">必須</span></label>
            <div id="preview-container">
                @if (old('image'))
                    <img id="preview" src="{{ asset('storage/' . old('image')) }}" alt="プレビュー画像" width="300">
                @else
                    <img id="preview" style="display: none;" width="300">
                @endif
            </div>
            <input type="file" name="image" id="image">
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>季節 <span class="required">必須</span><span class="note">複数選択可</span></label>
            @foreach ($seasons as $season)
                <label>
                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                        {{ (is_array(old('seasons')) && in_array($season->id, old('seasons'))) ? 'checked' : '' }}>
                    {{ $season->name }}
                </label>
            @endforeach
            @if ($errors->has('seasons'))
                <p class="error">{{ $errors->first('seasons') }}</p>
            @elseif ($errors->has('seasons.*'))
                <p class="error">{{ $errors->first('seasons.*') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="description">商品説明 <span class="required">必須</span></label>
            <textarea name="description" id="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-buttons">
            <a class="btn-gray" href="{{ route('products.index') }}">戻る</a>
            <button class="btn-yellow" type="submit">登録</button>
        </div>
    </form>
</div>

<script>
document.getElementById('image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
</script>

@endsection