<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['register' => false]);

Auth::routes();

Route::get('/', [App\Http\Controllers\MasterController::class, 'index'])->name('master__product');

Route::middleware('auth')->prefix('admin')->group(function (){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('product/')->name('product.')->group(function (){
        Route::get('', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('index');
        Route::get('add', [\App\Http\Controllers\Admin\ProductController::class, 'storeView'])->name('store-view');
        Route::post('', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('create');
        Route::get('{product_id}', [\App\Http\Controllers\Admin\ProductController::class, 'get'])->name('get');
        Route::put('{product_id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('update');
        Route::delete('{product_id}', [\App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('delete');
        Route::get('{product_id}/group', [\App\Http\Controllers\Admin\ProductController::class, 'getUserGroup'])->name('get-user-group');
        Route::put('{product_id}/group', [\App\Http\Controllrs\Admin\ProductController::class, 'updateUserGroup'])->name('update-user-group');
    });

    Route::prefix('category/')->name('category.')->group(function (){
        Route::get('', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
        Route::get('add', [\App\Http\Controllers\Admin\CategoryController::class, 'storeView'])->name('store-view');
        Route::post('', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('create');
        Route::get('{category_id}', [\App\Http\Controllers\Admin\CategoryController::class, 'get'])->name('get');
        Route::put('{category_id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
        Route::delete('{category_id}/delete', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('delete');
    });
});