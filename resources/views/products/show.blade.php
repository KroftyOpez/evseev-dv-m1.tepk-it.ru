@extends('layouts.layout')

@section('title', 'Материалы для ' . $product->name)

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Материалы для "{{ $product->name }}"</h2>

        @if ($product->productMaterials->isEmpty())
            <div class="alert alert-info">Нет назначенных материалов.</div>
        @else
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                <tr>
                    <th>Наименование материала</th>
                    <th>Количество</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($product->productMaterials as $pm)
                    <tr>
                        <td>{{ $pm->material->name }}</td>
                        <td>{{ number_format($pm->quantity, 2) }} {{ optional($pm->material->unit)->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('products.index') }}" class="btn btn-success">Назад к продуктам</a>
    </div>
@endsection
