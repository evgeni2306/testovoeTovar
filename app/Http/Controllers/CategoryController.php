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
            'stats' => 'array',
            'stats.*' => 'string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        $userId = User::getIdByKey($fields['authKey']);
        $category = Category::query()->create(['creator_id' => $userId, 'name' => $fields['name']]);
        Stat::createCategoriesStats($category->id, $fields['stats']);
        return response()->json($category->id, 200, ['Content-Type' => 'string']);
    }

    public function getList(): JsonResponse
    {
        $categories = Category::query()->get(['id', 'name'])->all();
        foreach ($categories as $item) {
            $item->stats = $item->getStats;
        }
        return response()->json($categories, 200, ['Content-Type' => 'array']);
    }

}
