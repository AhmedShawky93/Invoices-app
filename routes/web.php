<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();
// Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('invoices', [App\Http\Controllers\InvoicesController::class, 'index']);

Route::resource('sections', SectionsController::class);
Route::patch('sections/update', [SectionsController::class, 'update']);
Route::delete('sections/destroy', [SectionsController::class, 'destroy']);

Route::resource('products', ProductsController::class);
Route::patch('products/update', [ProductsController::class, 'update']);
Route::delete('products/destroy', [ProductsController::class, 'destroy']);

Route::get('/{page}', [AdminController::class, 'index']);
