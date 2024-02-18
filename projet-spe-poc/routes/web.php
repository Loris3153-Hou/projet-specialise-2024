<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POCController;


Route::get('/', function () {
    return view('app');
});


Route::get('/poc.poc', [POCController::class, 'ajax'])->name('ajax');

