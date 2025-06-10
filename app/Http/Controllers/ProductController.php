<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Вывод продуктов с расчётом стоимости
    public function index()
    {
        $products = Product::all();

        // Расчёт стоимости продукта
        $cost = [];
        foreach ($products as $product) {

            // Инициализируем стоимость для продукта с id = $product->id
            $cost[$product->id] = 0;

            $productMaterial = ProductMaterial::where('product_id', $product->id)->get();
            foreach ($productMaterial as $material) {
                if (isset($material->material)) {
                    $cost[$product->id] += $material->quantity * $material->material->price;
                }
            }
            // Округление до двух знаков после запятой
            $cost[$product->id] = round($cost[$product->id], 2);
        }
        return view('products.index', compact('products', 'cost'));
    }

    // Получение типов продуктов
    public function getType()
    {
        $product_types = ProductType::all();
        return view('products.create', compact('product_types'));
    }

    //
    public function store(ProductRequest $request)
    {
        // Создаем продукт
        Product::create($request->validated());
        // Перенаправляем обратно со статусом успеха
        return redirect()->route('products.index')->with('success', 'Продукт успешно добавлен');
    }

    public function show(Product $product)
    {
        // Загружаем продукты с информацией о количестве материала
        $materials = $product->productMaterials()
            ->with('material')
            ->get();

        return view('products.show', compact('product', 'materials'));
    }


    public function edit(Product $product)
    {
        $product_types = ProductType::all();
        return view('products.edit', compact('product', 'product_types'));
    }


    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        // Перенаправляем на страницу списка продуктов с сообщением об успехе
        return redirect()->route('products.index')->with('success', 'Продукт успешно обновлён');

    }
}
