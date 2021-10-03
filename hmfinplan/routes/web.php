<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\CustomerController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// customer controller
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers');
Route::delete('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'destroy']);
Route::patch('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'update']);
