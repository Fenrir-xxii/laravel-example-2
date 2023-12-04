<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponseOptionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', [TestController::class,'index'])->name('test.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/change-language/{language}', [LanguageController::class, 'changeLanguage']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/survey/{survey}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
    Route::post('/survey/{survey}/update', [SurveyController::class, 'update'])->name('surveys.update');
    Route::get('/survey/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/survey/store', [SurveyController::class, 'store'])->name('surveys.store');
    Route::delete('/survey/{survey}/destroy', [SurveyController::class,'destroy'])->name('surveys.destroy');
    Route::get('/survey/{survey}/show', [SurveyController::class, 'show'])->name('surveys.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/response-options/{survey}', [ResponseOptionController::class, 'index'])->name('options.index');
    Route::get('/response-options/create/{survey}', [ResponseOptionController::class, 'create'])->name('options.create');
    Route::post('/response-options/store/{survey}', [ResponseOptionController::class, 'store'])->name('options.store');
    Route::get('/response-options/{option}/edit', [ResponseOptionController::class, 'edit'])->name('options.edit');
    Route::post('/response-options/{option}/update', [ResponseOptionController::class, 'update'])->name('options.update');
    Route::delete('/response-options/{option}/destroy', [ResponseOptionController::class,'destroy'])->name('options.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/voting}', [VoteController::class, 'index'])->name('voting.index');
    Route::get('/voting/create/{survey}', [VoteController::class, 'create'])->name('voting.create');
    Route::post('/voting/store/', [VoteController::class, 'store'])->name('voting.store');

});

require __DIR__.'/auth.php';
