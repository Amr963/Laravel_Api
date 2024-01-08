<?php

use App\Http\Controllers\ApiCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\ApiTagController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Auth Route
Route::post('test/login', [AuthController::class, 'login']);
Route::post('test/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('test/logout', [Authcontroller::class, 'logout']);

// Product resource
Route::middleware('auth:sanctum')->resource('product', ApiProductController::class);
Route::middleware('auth:sanctum')->post('/product/{id}', [ApiProductController::class, 'update']);

// Category resource
Route::middleware('auth:sanctum')->resource('category', ApiCategoryController::class);
Route::middleware('auth:sanctum')->post('/category/{id}', [ApiCategoryController::class, 'update']);

// Tag resource
Route::middleware('auth:sanctum')->resource('tag', ApiTagController::class);
Route::middleware('auth:sanctum')->post('/tag/{id}', [ApiTagController::class, 'update']);

// Search By Name
Route::get('/searchByProductName/{search}', [ApiProductController::class, 'search']);
// Search By Min , Max Price
Route::post('/searchByProductPrice', [ApiProductController::class, 'searchByMaxMinPrice']);
// return 5 Product Highest Price
Route::get('/highestPrice', [ApiProductController::class, 'returnProductHighestPrice']);


