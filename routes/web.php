<?php

use App\Http\Controllers\MosqueeContactController;
use App\Http\Controllers\MosqueeController;
use App\Http\Controllers\MosqueeFollowerController;
use App\Http\Controllers\MosqueeImageController;
use App\Http\Controllers\MosqueeSharedController;
use App\Models\Mosquee_follower;
use Illuminate\Support\Facades\Route;
use App\Models\Mosquee;





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
    return view('index', [
        'all_data' => Mosquee_follower::all(),
        'all_mosquee' => Mosquee::all()
        // 'mosquee_follower' => Mosquee_follower::withCount('mosquee')->orderBy('mosquee_id', 'asc')->paginate(10),
        // 'mosquee' => $mosquee->mosquee_follower->count()
    ]);
});

Route::get('/mosquee/detail/{mosquee:uuid}', function(Mosquee $mosquee){
    return view('show', [
        'mosquee' => $mosquee,
        'mosquee_follower' => $mosquee->mosquee_follower->count()
    ]);
});


Route::resource('mosquee', MosqueeController::class);
Route::get('/mosquee/{mosquee:uuid}', [MosqueeController::class, 'detail']);
Route::resource('mosquee_images', MosqueeImageController::class);
Route::resource('mosquee_contact', MosqueeContactController::class);
Route::resource('mosquee_followers', MosqueeFollowerController::class);
Route::get('/mosquee_followers/{mosquee_follower:uuid}', [MosqueeFollowerController::class, 'detail']);
Route::resource('mosquee_shared', MosqueeSharedController::class);
// Route::resource('user', UserController::class)->middleware('guest');
// Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
// Route::post('login', [LoginController::class, 'autenticate'])->middleware('guest');
// Route::post('logout', [LoginController::class, 'logout']);
Route::resource('mosquee_shareds', MosqueeSharedController::class);

// Route::get('/m/{masjidId}', function($masjidId){

//     $masjid = Mosquee::findOrFail($masjidId);
//     $followerCount = $masjid->mosquee_follower->count();

//     return "Masjid " . $masjid->nama . " memiliki " . $followerCount . " follower.";
// });