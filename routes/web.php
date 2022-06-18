<?php

use Illuminate\Support\Facades\Route;
// use App\Controllers\ProductController;

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
    return view('product.list');
});


Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
Route::post('/product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
Route::post('/product/update', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::delete('/product/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('product.delete');
Route::get('/product/list', [App\Http\Controllers\ProductController::class, 'list'])->name('product.list');

Route::get('/sale', [App\Http\Controllers\SaleController::class, 'index'])->name('sale.index');
Route::post('/sale/register', [App\Http\Controllers\SaleController::class, 'saleRegister'])->name('sale.register');



