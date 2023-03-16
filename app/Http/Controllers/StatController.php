<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatController extends Controller
{
    public function create(Request $request)
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'name' => 'required|string|max:255',
            'categoryId' => 'required|integer|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        $userId = User::getIdByKey($fields['authKey']);
        $stat = Stat::query()->create(['creator_id' => $userId, 'category_id' => $fields['categoryId'], 'name' => $fields['name']]);
        return response()->json(['statId' => $stat->id], 200, ['Content-Type' => 'string']);
    }

    public function delete(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'statId' => 'required|integer|exists:stats,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        Stat::deleteWithDependencies((int)$fields['statId']);
        return response()->json(['message' => 'deleted'], 200, ['Content-Type' => 'string']);
    }

    public function update(Request $request): JsonResponse
    {
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'authKey' => 'required|string|max:255|exists:users,authKey',
            'name' => 'required|string|max:255',
            'statId' => 'required|integer|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        $stat = Stat::query()->find($fields['statId']);
        $stat->name = $fields['name'];
        $stat-> save();
        return response()->json(['message' => 'обновлено'], 200, ['Content-Type' => 'string']);
    }
}
