<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\DzikirController;
use App\Http\Controllers\Api\FiqihController;
use App\Http\Controllers\Api\HadistController;
use App\Http\Controllers\Api\MosqueeController;
use App\Http\Controllers\Api\MurottalController;
use App\Http\Controllers\Api\StudyController;
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

Route::prefix('mosquee')->group(function () {
    Route::get('/', [MosqueeController::class, 'index']);
    Route::get('/{mosquee}', [MosqueeController::class, 'show']);
});
Route::prefix('hadist')->group(function () {
    Route::get('/', [HadistController::class, 'index']);
    Route::get('/chapters', [HadistController::class, 'chapters']);
    Route::get('/categories', [HadistController::class, 'categories']);
    Route::get('/{hadist}', [HadistController::class, 'show']);
});
Route::prefix('article')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/{article}', [ArticleController::class, 'show']);
});
Route::prefix('study')->group(function () {
    Route::get('/', [StudyController::class, 'index']);
    Route::get('/categories', [StudyController::class, 'categories']);
    Route::get('/{study}', [StudyController::class, 'show']);
});
Route::prefix('dzikir')->group(function () {
    Route::get('/', [DzikirController::class, 'index']);
    Route::get('/categories', [DzikirController::class, 'categories']);
    Route::get('/{dzikir}', [DzikirController::class, 'show']);
});
Route::prefix('murottal')->group(function () {
    Route::get('/', [MurottalController::class, 'index']);
    Route::get('/qaris', [MurottalController::class, 'qaris']);
    Route::get('/{murottal}', [MurottalController::class, 'show']);
});
Route::prefix('fiqih')->group(function () {
    Route::get('/', [FiqihController::class, 'index']);
});
