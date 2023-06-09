<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StatValue;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'name' => 'required|string|max:255|unique:categories,name',
            'price' => 'integer|required',
            'amount' => 'integer',
            'description' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        $fields['creator_id'] = User::getIdByKey($fields['authKey']);
        $product = Product::query()->create($fields);
        return response()->json(['productId' => $product->id], 200, ['Content-Type' => 'string']);
    }

    public function list(): JsonResponse
    {
        $products = Product::query()->get(['id', 'name', 'price', 'amount'])->all();
        return response()->json($products, 200, ['Content-Type' => 'string']);
    }

    public function view($id): JsonResponse
    {
        $product = Product::query()->find($id);
        if ($product === null) {
            return response()->json(['message' => 'Выбранный товар не найден'], 404, ['Content-Type' => 'string']);
        }
        $product->stats = $product->getStats;
        return response()->json($product, 200, ['Content-Type' => 'string']);
    }

    public function listByCategory($id): JsonResponse
    {
        $products = Product::findByCategorie($id);
        if ($products === null) {
            return response()->json(['message' => 'По выбранной категории товары не найдены'], 404, ['Content-Type' => 'string']);
        }
        return response()->json($products, 200, ['Content-Type' => 'string']);
    }

    public function delete(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'productId' => 'required|integer|exists:products,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        Product::deleteWithDependencies((int)$fields['productId']);
        return response()->json(['message' => 'deleted'], 200, ['Content-Type' => 'string']);
    }

    public function deleteCategory(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'productId' => 'required|integer|exists:products,id',
            'categoryId' => 'integer|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        Product::deleteCategoryConnection($fields['productId'], $fields['categoryId']);
        return response()->json(['message' => 'Товар был отвязан от категории'], 200, ['Content-Type' => 'string']);
    }

    public function addCategory(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'productId' => 'required|integer|exists:products,id',
            'categoryId' => 'integer|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        Product::addCategoryConnection($fields['productId'], $fields['categoryId']);
        return response()->json(['message' => 'Категория была привязана'], 200, ['Content-Type' => 'string']);
    }

    public function updateStatValue(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'productId' => 'required|integer|exists:products,id',
            'value' => 'required|string|max:255',
            'statId' => 'required|integer|exists:stats,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        StatValue::updateProductStatValue($fields['productId'], $fields['statId'], $fields['value']);
        return response()->json(['message' => 'Свойство было обновлено'], 200, ['Content-Type' => 'string']);
    }

    public function update(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'productId' => 'required|integer|exists:products,id',
            'name' => 'string|max:255',
            'price' => 'integer',
            'amount' => 'integer',
            'description' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        Product::updateProduct($fields);
        return response()->json(['message' => 'Товар был обновлен'], 200, ['Content-Type' => 'string']);
    }

}
