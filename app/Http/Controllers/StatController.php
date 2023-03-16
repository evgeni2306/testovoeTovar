<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Stat;
use App\Models\User;
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
}
