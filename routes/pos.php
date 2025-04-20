<?php

use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductVariationController;
use App\Http\Controllers\ProfileController;
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
        return view('frontend.home');
    })->name('frontend.home');






//backend routes start
Route::get('/dashboard', function () {
        return view('backend.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);

    Route::resource('product-variation', ProductVariationController::class);
    Route::get('/get-variation-values/{type}', [ProductVariationController::class, 'getVariationValues']);

    
});



require __DIR__.'/auth.php';
