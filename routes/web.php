<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MonsterController;



Route::get('/', [PagesController::class, 'homeAction'])->name('home');

Route::get('/monsters', 
[MonsterController::class,'index'])
    ->name('monsters.index');
