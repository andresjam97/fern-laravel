<?php

use App\Http\Controllers\Imports\ImportsController;
use App\Http\Controllers\Orders\ordersController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('orders')->controller(ordersController::class)->group(function () {
    Route::get('','index')->name('orders-name');
    Route::post('','createOrder')->name('orders-create');
    Route::get('getOrders','getOrders')->name('orders-get');
    Route::get('getOrderDetails/{id}','getorderDetails')->name('orders-get-details');

    Route::get('{id}','orderDetails')->name('orders-details');
    Route::post('{id}','orderDetailsInsert')->name('orders-details-insert');

    Route::post('send','sendOrder')->name('orders-details-send');

});

Route::prefix('imports')->controller(ImportsController::class)->group(function () {
    Route::get('employees','employeVw')->name('import-employe-vw');
    Route::post('employees','importEmployes')->name('import-employe');

    Route::get('books','bookVw')->name('import-book-vw');
    Route::post('books','importBooks')->name('import-book');

    Route::get('schools','schoolVw')->name('import-book-vw');
    Route::post('schools','importSchools')->name('import-school');
});

