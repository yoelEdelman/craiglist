<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdvertController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {return Inertia\Inertia::render('Dashboard');})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/favorite', [AdvertController::class,'displayFavorite'])->name('favorite');
Route::middleware(['auth:sanctum', 'verified'])->delete('/favorite', [AdvertController::class,'deleteFavorite'])->name('deleteFavorite');
Route::middleware(['auth:sanctum', 'verified'])->delete('/myAdvert', [AdvertController::class,'deleteMyAdvert'])->name('myAdvert');
Route::middleware(['auth:sanctum', 'verified'])->get('/myAdvert', [AdvertController::class,'showMyAdvert'])->name('myAdvert');
Route::middleware(['auth:sanctum', 'verified'])->get('/createAdvert', [AdvertController::class,'postAdvert'])->name('createAdvert');
Route::middleware(['auth:sanctum', 'verified'])->post('/createAdvert', [AdvertController::class,'create']);
Route::middleware(['auth:sanctum', 'verified'])->get('/modeEdition/{slug}', [AdvertController::class,'edit'])->name('modeEdition');
Route::middleware(['auth:sanctum', 'verified'])->put('/modeEdition/{slug}', [AdvertController::class,'update']);

Route::get('/allCity', [CityController::class,'selectCity']);
Route::get('/',[CityController::class,'index'])->name('home');
Route::get('/search',[AdvertController::class,'searchAdverts'])->name('Search');

Route::get('/{city}',[CategoryController::class,'show'])->name('category');
Route::get('/{city}/{category}',[AdvertController::class,'advertCategory']);
Route::get('/{city}/{category}/{subcategory}',[AdvertController::class,'advertSubCategory']);
Route::get('/{city}/{category}/{subcategory}/{slug}',[AdvertController::class,'show'])->name('AdvertSelected');
Route::get('/{city}/{category}/{subcategory}/{slug}/share',[AdvertController::class,'showShare']);
Route::get('/{city}/{category}/{subcategory}/{slug}/response',[AdvertController::class,'showResponseAdvert']);

Route::post('/{city}/{category}/{subcategory}/{slug}/share',[AdvertController::class,'shareAdvert']);
Route::post('/{city}/{category}/{subcategory}/{slug}/response',[AdvertController::class,'responseToAdvert']);
Route::post('/{city}/{category}/{subcategory}/{slug}',[AdvertController::class,'addToFavorite']);



