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

Route::get('/', function () {
    return view('home');
});

Route::view('/reports/capital-gain', 'capitalgain')->name('capitalgain');
Route::view('/reports/sharepro-recon', 'shareprorecon')->name('shareprorecon');
Route::view('/reports/corp-actn-nse', 'corpactnnse')->name('corpactnnse');
Route::view('/reports/corp-actn-bse', 'corpactnbse')->name('corpactnbse');
Route::view('/reports/pms-fees-recon', 'pmsfeesrecon')->name('pmsfeesrecon');
Route::view('/reports/pms-bill-ledger', 'pmsbillledger')->name('pmsbillledger');
Route::view('/reports/tradejini-brokerage', 'tradejinibrokerage')->name('tradejinibrokerage');
Route::view('/reports/orbis-custody-file', 'orbiscustodyfile')->name('orbiscustodyfile');