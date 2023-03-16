<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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
            'categories' => 'array',
            'categories.*' => 'integer|exists:categories,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        $fields['creator_id'] = User::getIdByKey($fields['authKey']);
        $product = Product::query()->create($fields);
        Category::connectionToProduct($product->id, $fields['categories']);
        return response()->json(['productId' => $product->id], 200, ['Content-Type' => 'string']);
    }

    public function list(): JsonResponse
    {
        $products = Product::query()->get(['id', 'name', 'price', 'amount'])->all();
        return response()->json($products, 200, ['Content-Type' => 'string']);
    }

    public function view(int $id): JsonResponse
    {
        $product = Product::query()->find($id);
        if ($product === null) {
            return response()->json(['message' => 'Выбранный товар не найден'], 404, ['Content-Type' => 'string']);
        }
        return response()->json($product, 200, ['Content-Type' => 'string']);
    }

    public function listByCategory(int $id): JsonResponse
    {
        $products = Product::findByCategorie($id);
        return response()->json($products, 200, ['Content-Type' => 'string']);
    }

    public function delete(Request $request)
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'categoryId' => 'required|integer|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        Product::deleteWithDependencies((int)$fields['categoryId']);
        return response()->json(['message' => 'deleted'], 200, ['Content-Type' => 'string']);
    }
}
