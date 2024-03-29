<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/dashboard');
});



Auth::routes(['register' => false,'reset' => false,'verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/invoice-genarte/{id}', [App\Http\Controllers\HomeController::class, 'invoiceGenarate'])->name('invoiceGenarate');

Route::get('/batch-invoice/', [App\Http\Controllers\HomeController::class, 'batchInvoice'])->name('batchInvoice');

Route::get('home', function () {
    return redirect('/dashboard');
});

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
