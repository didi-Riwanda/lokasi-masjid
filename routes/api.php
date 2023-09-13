<?php

use App\Http\Controllers\Api\MosqueeContactController;
use App\Http\Controllers\Api\MosqueeController;
use App\Http\Controllers\Api\MosqueeFollowerController;
use App\Http\Controllers\Api\MosqueeImageController;
use App\Http\Controllers\Api\MosqueeSharedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/mosquee', MosqueeController::class);
Route::apiResource('/mosquee_images', MosqueeImageController::class);
Route::apiResource('/mosquee_contacts', MosqueeContactController::class);
Route::apiResource('/mosquee_followers', MosqueeFollowerController::class);
Route::apiResource('/mosquee_shareds', MosqueeSharedController::class);