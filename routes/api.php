<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
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
Route::get('/category/{id}', [CategoryController::class, "show"]);
Route::post('/categories', [CategoryController::class, "store"]);
Route::put('/category/{id}', [CategoryController::class, "update"]);
Route::delete('/categories/{id}', [CategoryController::class, "delete", []]);
