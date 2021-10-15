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
// Route::post('/home/debug', [App\Http\Controllers\HomeController::class, 'debug'])->name('debug');

// customer controller
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers');
Route::get('/customers/{customer}/dashboard', [App\Http\Controllers\CustomerController::class, 'show'])->name('customer.dashboard');
Route::delete('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'destroy']);
Route::patch('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'update']);
Route::post('/customers', [App\Http\Controllers\CustomerController::class, 'store']);

// personal details controller
Route::get('/customers/{customer}/personal', [App\Http\Controllers\PersonalDetailController::class, 'index'])->name('customer.personal');
Route::post('/customers/{customer}/personal', [App\Http\Controllers\PersonalDetailController::class, 'store']);
Route::patch('/customers/{customer}/personal/{personal}', [App\Http\Controllers\PersonalDetailController::class, 'update']);
Route::delete('/customers/{customer}/personal/{personal}', [App\Http\Controllers\PersonalDetailController::class, 'destroy']);

// family member controller
Route::get('/customers/{customer}/family', [App\Http\Controllers\FamilyMemberController::class, 'index'])->name('customer.family');
Route::post('/customers/{customer}/family', [App\Http\Controllers\FamilyMemberController::class, 'store']);
Route::patch('/customers/{customer}/family/{family}', [App\Http\Controllers\FamilyMemberController::class, 'update']);
Route::delete('/customers/{customer}/family/{family}', [App\Http\Controllers\FamilyMemberController::class, 'destroy']);

// profession detail controller
Route::get('/customers/{customer}/profession', [App\Http\Controllers\ProfessionalDetailsController::class, 'index'])->name('customer.profession');
Route::post('/customers/{customer}/profession', [App\Http\Controllers\ProfessionalDetailsController::class, 'store']);
Route::patch('/customers/{customer}/profession/{profession}', [App\Http\Controllers\ProfessionalDetailsController::class, 'update']);
Route::delete('/customers/{customer}/profession/{profession}', [App\Http\Controllers\ProfessionalDetailsController::class, 'destroy']);

// assets controller
Route::get('/customers/{customer}/realestate', [App\Http\Controllers\RealEstateController::class, 'index'])->name('customer.assets');
Route::post('/customers/{customer}/realestate', [App\Http\Controllers\RealEstateController::class, 'store']);
Route::patch('/customers/{customer}/realestate/{realestate}', [App\Http\Controllers\RealEstateController::class, 'update']);
Route::delete('/customers/{customer}/realestate/{realestate}', [App\Http\Controllers\RealEstateController::class, 'destroy']);