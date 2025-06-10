@extends('layouts.layout')

@section('title', 'Товары')

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-center">Список продукции</h1>
        <a href="{{ route('products.getType') }}" class="btn btn-success m-3">Добавить товар</a>
        @foreach ($products as $product)
            <div class="product-card row align-items-center border   p-3 mb-4 ">
                <div class="col-md-9">
                    <h4><strong>{{ optional($product->productType)->name }} | {{ $product->name }}</strong></h4>
                    <p class="fs-5">Артикул: {{ $product->article }}</p>
                    <p class="fs-5">Минимальная стоимость для партнера (Р): {{ number_format($product->minPrice, 2, '.', '') }}</p>
                    <p class="fs-5">Ширина (м): {{ $product->width }}</p>
                </div>
                <div class="col-md-3 text-end">
                    <h4 class="fw-bold"> Стоимость: {{ number_format($cost[$product->id], 2, '.', '') }} (р) </h4>
                </div>
                <div>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-success me-2">Просмотр</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success me-2">Редактировать</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection

