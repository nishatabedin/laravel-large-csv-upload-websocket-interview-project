<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestWsEventController;
use App\Http\Controllers\Product\ProductImportController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //product routes
    Route::post('products-import', [ProductImportController::class, 'store'])->name('products.import');
    Route::get('get-upload-history', [ProductImportController::class, 'upload_history'])->name('upload.history');
});

//Test websocket event route
Route::get('/test' ,[TestWsEventController::class , 'testingWsEvents']);

require __DIR__.'/auth.php';
