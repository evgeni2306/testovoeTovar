<?php

use App\Http\Controllers\api\Authentication\AuthorizationController;
use App\Http\Controllers\api\Authentication\RegistrationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatController;
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
Route::post('/category/update', [CategoryController::class, 'update']);
Route::post('/category/delete', [CategoryController::class, 'delete']);
Route::get('/category/list', [CategoryController::class, 'list']);
Route::get('/category={id}', [CategoryController::class, 'view']);


Route::post('/product/create', [ProductController::class, 'create']);
Route::post('/product/update', [ProductController::class, 'update']);
Route::post('/product/delete', [ProductController::class, 'delete']);
Route::post('/product/category/delete', [ProductController::class, 'deleteCategory']);
Route::post('/product/stat/update', [ProductController::class, 'updateStatValue']);
Route::post('/product/category/add', [ProductController::class, 'addCategory']);
Route::get('/product/list', [ProductController::class, 'list']);
Route::get('/product={id}', [ProductController::class, 'view']);
Route::get('/product/category={id}', [ProductController::class, 'listByCategory']);

Route::post('/stat/create', [StatController::class, 'create']);
Route::post('/stat/update', [StatController::class, 'update']);
Route::post('/stat/delete', [StatController::class, 'delete']);
