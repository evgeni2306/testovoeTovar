<?php

use App\Http\Controllers\api\Authentication\AuthorizationController;
use App\Http\Controllers\api\Authentication\RegistrationController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/registration', [RegistrationController::class, 'registration']);
Route::post('/login', [AuthorizationController::class, 'login']);
Route::post('/category/create', [CategoryController::class, 'create']);
