<?php
declare(strict_types=1);
namespace App\Http\Controllers\api\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthorizationController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $fields = $request->all('login', 'password');
        $validator = Validator::make($fields, [
            'login' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404, ['Content-Type' => 'string']);
        }
        if (Auth::attempt($fields)) {
            return response()->json(['authKey' => Auth::user()->authKey], 200);
        }
        return response()->json([['message' => 'Не удалось авторизоваться, проверьте правильность заполнения полей']], 404, ['Content-Type' => 'string']);
    }
}
