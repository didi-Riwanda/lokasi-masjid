<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DzikirController;
use App\Http\Controllers\FilesystemBuildController;
use App\Http\Controllers\FiqihController;
use App\Http\Controllers\HadistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MosqueeContactController;
use App\Http\Controllers\MosqueeController;
use App\Http\Controllers\MosqueeImageController;
use App\Http\Controllers\MurottalController;
use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('mosquee', MosqueeController::class);
    Route::resource('article', ArticleController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('study', StudyController::class);
    Route::resource('murottal', MurottalController::class);
    Route::prefix('mosquee/{mosquee}')->name('mosquee.')->group(function () {
        Route::resource('contact', MosqueeContactController::class);
        Route::resource('gallery', MosqueeImageController::class);
    });
    Route::resource('hadist', HadistController::class);
    Route::resource('dzikir', DzikirController::class);
    Route::resource('fiqih', FiqihController::class);

    Route::post('ckupload', function (Request $request) {
        $originName = $request->file('upload')->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $request->file('upload')->getClientOriginalExtension();
        $fileName = $fileName . '_' . time() . '.' . $extension;

        $request->file('upload')->move(public_path('media'), $fileName);

        $url = asset('media/' . $fileName);
        return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
    })->name('image.upload');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'process']);
});

Route::prefix('image')->name('image.')->group(function () {
    Route::get('/{path}', [FilesystemBuildController::class, 'image'])->where('path', '(.*)')->name('url');
});
Route::prefix('audio')->name('audio.')->group(function () {
    Route::get('/{path}', [FilesystemBuildController::class, 'audio'])->where('path', '(.*)')->name('url');
});

Route::get('/create/user', function () {
    User::create([
        'email' => 'ayam.goreng@ashiilapp.com',
        'password' => bcrypt('@Goreng.Ayam891X'),
        'name' => 'Admin Ashiilapp',
    ]);
});
