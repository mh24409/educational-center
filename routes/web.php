<?php

use Carbon\Carbon;
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



Auth::routes();

// Route::get('/home', [App\Http\Controllers\admin\HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    //  echo config('app.name');
    $d = carbon::now();
    $array = $d->toArray();
   return $array['hour'];
});
