<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['domain' => env('APP_URL')], function () {
    Route::prefix('/v1')->group(function (){

        Route::prefix('/product')->group(function(){
            Route::post('/create', [ProductController::class, 'create'])->name('product.create');
        });

        Route::post('/order',[OrderController::class,'store'])->name('order.store');
        Route::get('/orders',[OrderController::class,'index'])->name('order.index');
        Route::get('/order/{orderId}',[OrderController::class,'show'])->name('order.show');
        Route::delete('/order/{orderId}',[OrderController::class,'destroy'])->name('order.destroy');


        Route::get('discount/{orderId}', [DiscountController::class, 'calculateDiscounts']);
    });
});
