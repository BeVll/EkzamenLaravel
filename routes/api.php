<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/categories', [CategoryController::class, "index"]);
Route::get('/categoriesAll', [CategoryController::class, "all"]);
Route::get('/category/{id}', [CategoryController::class, "show"]);
Route::post('/categories', [CategoryController::class, "store"]);
Route::post('/category/{id}/{check}', [CategoryController::class, "update"]);
Route::delete('/categories/{id}', [CategoryController::class, "delete", []]);

Route::get('/products', [ProductController::class, "index"]);
Route::get('/product/{id}', [ProductController::class, "show"]);
Route::post('/products', [ProductController::class, "store"]);
Route::post('/product/{id}/{check}', [ProductController::class, "update"]);
Route::delete('/product/{id}', [ProductController::class, "delete", []]);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
