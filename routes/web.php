<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DzikirController;
use App\Http\Controllers\FilesystemBuildController;
use App\Http\Controllers\HadistController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MosqueeContactController;
use App\Http\Controllers\MosqueeController;
use App\Http\Controllers\MosqueeFollowerController;
use App\Http\Controllers\MosqueeImageController;
use App\Http\Controllers\MosqueeSharedController;
use App\Http\Controllers\MurottalController;
use App\Http\Controllers\StudyController;
use App\Models\Hadist;
use Illuminate\Support\Facades\Route;
use App\Models\Mosquee;
use App\Models\MosqueeFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

Route::get('/', function (Mosquee $mosquee) {
    // // return view('index', [
    // //     'all_data' => MosqueeFollower::all(),
    // //     'all_mosquee' => Mosquee::all()
    // //     // 'mosquee_follower' => Mosquee_follower::withCount('mosquee')->orderBy('mosquee_id', 'asc')->paginate(10),
    // //     // 'mosquee' => $mosquee->mosquee_follower->count()
    // // ]);

    // // return Cache::remember('mosquee', 60, function () {
    // //     return Mosquee::all();
    // // });

    // $content = file_get_contents(__DIR__.'/./mytext.txt');
    // $splits = preg_split('/\),\([0-9]+,/', $content);
    // $splits[0] = preg_replace('/^\([0-1]+,/', '', $splits[0]);
    // echo '<pre>';
    // foreach ($splits as $split) {
    //     $contexts = explode("','", $split);
    //     $title = preg_replace('/^(\,|\')/', '', $contexts[0]);
    //     $source = $contexts[1];
    //     $text = $contexts[2];
    //     $translation = $contexts[3];
    //     $category = $contexts[4];
    //     $noted = $contexts[5];

    //     // Hadist::create([
    //     //     'title' => $title,
    //     //     'source' => $source,
    //     //     'text' => $text,
    //     //     'translation' => $translation,
    //     //     'category' => $category,
    //     //     'noted' => $noted,
    //     // ]);
    // }

    // return Hadist::all();
    return view('index');
})->name('home');

Route::get('/mosquee/detail/{mosquee:uuid}', function(Mosquee $mosquee){
    return view('show', [
        'mosquee' => $mosquee,
        'mosquee_follower' => $mosquee->mosquee_follower->count()
    ]);
});


Route::resource('mosquee', MosqueeController::class);
Route::resource('article', ArticleController::class);
Route::resource('category', CategoryController::class);
Route::resource('study', StudyController::class);
Route::resource('murottal', MurottalController::class);
Route::resource('hadist', HadistController::class);
Route::resource('dzikir', DzikirController::class);
// Route::resource('hadist', ArticleController::class);
// Route::get('/mosquee/{mosquee:uuid}', [MosqueeController::class, 'detail']);
// Route::resource('mosquee_images', MosqueeImageController::class);
// Route::resource('mosquee_contact', MosqueeContactController::class);
// Route::resource('mosquee_followers', MosqueeFollowerController::class);
// Route::get('/mosquee_followers/{mosquee_follower:uuid}', [MosqueeFollowerController::class, 'detail']);
// Route::resource('mosquee_shared', MosqueeSharedController::class);
// Route::resource('user', UserController::class)->middleware('guest');
// Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
// Route::post('login', [LoginController::class, 'autenticate'])->middleware('guest');
// Route::post('logout', [LoginController::class, 'logout']);
// Route::resource('mosquee_shareds', MosqueeSharedController::class);

// Route::get('/m/{masjidId}', function($masjidId){

//     $masjid = Mosquee::findOrFail($masjidId);
//     $followerCount = $masjid->mosquee_follower->count();

//     return "Masjid " . $masjid->nama . " memiliki " . $followerCount . " follower.";
// });

Route::post('ckupload', function (Request $request) {
    $originName = $request->file('upload')->getClientOriginalName();
    $fileName = pathinfo($originName, PATHINFO_FILENAME);
    $extension = $request->file('upload')->getClientOriginalExtension();
    $fileName = $fileName . '_' . time() . '.' . $extension;

    $request->file('upload')->move(public_path('media'), $fileName);

    $url = asset('media/' . $fileName);
    return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
})->name('image.upload');

Route::prefix('image')->name('image.')->group(function () {
    Route::get('/{path}', [FilesystemBuildController::class, 'image'])->where('path', '(.*)')->name('url');
});
Route::prefix('audio')->name('audio.')->group(function () {
    Route::get('/{path}', [FilesystemBuildController::class, 'audio'])->where('path', '(.*)')->name('url');
});
