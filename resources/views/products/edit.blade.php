@extends('layouts.layout')

@section('title', 'Редактировать товар')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Редактировать товар</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label  for="product_type_id" class="form-label fs-4">Тип продукта</label>
                <select name="product_type_id" id="product_type_id" class="form-control" required>
                    @foreach ($product_types as $type)
                        <option value="{{ $type->id }}" {{ $type->id == $product->product_type_id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label fs-4">Наименование</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="article" class="form-label fs-4">Артикул</label>
                <input type="text" name="article" id="article" class="form-control" value="{{ old('article', $product->article) }}" required>
                @error('article')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="minPrice" class="form-label fs-4">Минимальная стоимость для партнера (Р)</label>
                <input type="number" step="0.01" name="minPrice" id="minPrice" class="form-control"
                       value="{{ old('minPrice', $product->minPrice) }}" required>
                @error('minPrice')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="width" class="form-label fs-4">Ширина (м)</label>
                <input type="number" step="0.01" name="width" id="width" class="form-control"
                       value="{{ old('width', $product->width) }}" required>
                @error('width')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
