<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
