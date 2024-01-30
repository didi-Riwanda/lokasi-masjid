<?php

use Alaouy\Youtube\Facades\Youtube;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DzikirController;
use App\Http\Controllers\FilesystemBuildController;
use App\Http\Controllers\FiqihController;
use App\Http\Controllers\HadistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MosqueeContactController;
use App\Http\Controllers\MosqueeController;
use App\Http\Controllers\MosqueeImageController;
use App\Http\Controllers\MosqueeScheduleController;
use App\Http\Controllers\MurottalController;
use App\Http\Controllers\StudyController;
use App\Models\Article;
use App\Models\Study;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

Route::get('/testing', function () {
    $studies = Study::whereNull('thumbnails')->get();
    foreach ($studies as $study) {
        $vid = Youtube::parseVidFromURL($study->url);
        $info = Youtube::getVideoInfo($vid);

        if (isset($info->snippet->thumbnails)) {
            $study->thumbnails = json_encode($info->snippet->thumbnails);
            $study->save();
        } else {
            dd($info->snippet->thumbnails);
        }
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('mosquee', MosqueeController::class);
    Route::prefix('mosquee/{mosquee}')->name('mosquee.')->group(function () {
        Route::resource('contact', MosqueeContactController::class);
        Route::resource('gallery', MosqueeImageController::class);
        Route::resource('schedule', MosqueeScheduleController::class);
    });
    Route::resource('article', ArticleController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('study', StudyController::class);
    Route::resource('murottal', MurottalController::class);
    Route::prefix('hadist')->name('hadist.')->group(function () {
        Route::get('/categories', [HadistController::class, 'categories']);
        Route::post('/categories', [HadistController::class, 'categories']);
        Route::delete('/categories', [HadistController::class, 'categories']);
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
Route::prefix('document')->name('document.')->group(function () {
    Route::get('/{path}', [FilesystemBuildController::class, 'document'])->where('path', '(.*)')->name('url');
});

Route::resource('donation', DonationController::class);

// Route::get('/create/user', function () {
//     User::create([
//         'email' => 'ayam.goreng@ashiilapp.com',
//         'password' => bcrypt('@Goreng.Ayam891X'),
//         'name' => 'Admin Ashiilapp',
//     ]);
// });

// Route::get('/file/clear', function () {
//     $articles = Article::all();
//     $caches = collect();
//     foreach ($articles as $article) {
//         $caches->add(explode(',', $article->imgsrc));
//     }

//     $caches = $caches->flatten()->toArray();
//     foreach ($caches as $key => $value) {
//         $caches[$key] = str_replace('articles/', '', $value);
//     }

//     $path = storage_path('app/articles');
//     $files = scandir($path);
//     unset($files[0], $files[1]);
//     foreach ($files as $file) {
//         $target = $path . '/' . $file;
//         if (is_file($target) && !in_array($file, $caches)) {
//             @unlink($target);
//         }
//     }
// });
