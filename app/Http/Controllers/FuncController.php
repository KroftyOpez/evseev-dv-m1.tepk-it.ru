<?php

namespace App\Http\Controllers;

use App\Models\MaterialType;
use App\Models\ProductType;
use Illuminate\Http\Request;

class FuncController extends Controller
{
    /**
     * Рассчитывает необходимое количество материала для производства продукции
     * @param ProductType $productTypeId ID типа продукции
     * @param MaterialType $materialTypeId ID типа материала
     * @param int $productCount Количество продукции
     * @param float $param1 Первый параметр продукции
     * @param float $param2 Второй параметр продукции
     * @param float $stockQuantity Количество материала на складе
     * @return int Целое количество закупаемого материала или -1 при ошибках
     */
    public function calculateRequiredMaterial(ProductType $productTypeId, MaterialType $materialTypeId, int $productCount, float $param1, float $param2, float $stockQuantity): int {
        try {
            // Проверка корректности данных
            if ($productCount <= 0 || $param1 <= 0 || $param2 <= 0 || $stockQuantity < 0) {
                return -1;
            }
            // Получаем тип продукции из базы данных
            $productType = ProductType::findOrFail($productTypeId);
            if (!$productType instanceof ProductType) {
                return -1;
            }
            // Получаем тип материала из базы данных
            $materialType = MaterialType::findOrFail($materialTypeId);
            if (!$materialType instanceof MaterialType) {
                return -1;
            }
            // Коэффициент типа продукции
            $coefficient = $productType->coefficient;
            // Процент брака материала
            $defectPercent = $materialType->defect;
            // Общее требуемое количество материала без учета брака
            $requiredMaterial = $param1 * $param2 * $coefficient * $productCount;
            // Учет брака: увеличиваем на процент дефектов
            $totalWithDefect = $requiredMaterial * (1 + $defectPercent / 100);
            // Вычисляем разницу между необходимым количеством и запасом на складе
            $neededMaterial = max(0, ceil($totalWithDefect - $stockQuantity));
            return $neededMaterial;
        } catch (Exception $e) {
            // Возвращаем -1 при любых исключениях
            return -1;
        }
    }
}
