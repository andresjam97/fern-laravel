<?php

use App\Http\Controllers\Imports\ImportsController;
use App\Http\Controllers\Orders\ordersController;
use App\Http\Controllers\QqsmController;
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
    Route::get('management/aprove','orderManagementAproveView')->name('orders-name-management');
    Route::post('','createOrder')->name('orders-create');
    Route::get('getOrders','getOrders')->name('orders-get');
    Route::get('getOrderDetails/{id}','getorderDetails')->name('orders-get-details');
    Route::get('getSchools/{id}','getSchools')->name('orders-get-schools');
    Route::post('sendOrderDetails','sendOrderDetails');
    Route::get('confirm/{id}','orderConfirmDelivery')->name('orders-confirm-delivery');

    Route::get('{id}','orderDetails')->name('orders-details');
    Route::post('{id}','orderDetailsInsert')->name('orders-details-insert');
});

Route::prefix('game')->controller(QqsmController::class)->middleware('auth')->group(function () {
    Route::get('','index')->name('game-qqsm');
    Route::post('', 'startNewGame');
    Route::get('create-question','createQuestionVw')->name('create-question-vw');
    Route::post('create-question','createQuestion')->name('create-question');

    Route::get("last-game", 'reloadPreviousGame');
    Route::get("ranking-score", 'ranksByScore');
    Route::get("ranking-accuracy", 'ranksByAccuracy');
    Route::put('{game}/check-answer', 'checkAnswer');
    Route::get("truncate", 'truncate')->name('truncate');


});

Route::prefix('imports')->controller(ImportsController::class)->group(function () {
    Route::get('employees','employeVw')->name('import-employe-vw');
    Route::post('employees','importEmployes')->name('import-employe');

    Route::get('books','bookVw')->name('import-book-vw');
    Route::post('books','importBooks')->name('import-book');

    Route::get('schools','schoolVw')->name('import-book-vw');
    Route::post('schools','importSchools')->name('import-school');


    Route::get('questions','questionsVw')->name('import-questions-vw');
    Route::post('questions-import','importQuestions')->name('import-questions');
});

