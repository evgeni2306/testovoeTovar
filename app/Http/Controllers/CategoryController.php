<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        $userId = User::getIdByKey($fields['authKey']);
        $category = Category::query()->create(['creator_id' => $userId, 'name' => $fields['name']]);
        return response()->json(['categoryId' => $category->id], 200, ['Content-Type' => 'string']);
    }

    public function list(): JsonResponse
    {
        $categories = Category::query()->get(['id', 'name'])->all();
        return response()->json($categories, 200, ['Content-Type' => 'array']);
    }

    public function view(int $id): JsonResponse
    {
        $category = Category::query()->find($id);
        if ($category === null) {
            return response()->json(['message' => 'Выбранная категория не найдена'], 404, ['Content-Type' => 'string']);
        }
        $category->stats = $category->getStats;
        return response()->json($category, 200, ['Content-Type' => 'string']);
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
        Category::deleteWithDependencies((int)$fields['categoryId']);
        return response()->json(['message'=>'deleted'], 200, ['Content-Type' => 'string']);
    }

}
