<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ManagerOrdersController;
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

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name('api.login');
    Route::group(['middleware'=>'jwt.auth'], function (){
        Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('api.refresh');
        Route::get('me', [AuthController::class, 'me'])->name('api.me');

        Route::get('orders',[ManagerOrdersController::class,'allOrders'])->name('api.orders');
        Route::get('order/{order_id}',[ManagerOrdersController::class,'getOrder'])->name('api.order.get');
        Route::post('change_order',[ManagerOrdersController::class,'changeOrder'])->name('api.order.change');

    });
});
