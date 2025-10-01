<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kantin;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/Homekantin', [kantin::class, 'index']);

