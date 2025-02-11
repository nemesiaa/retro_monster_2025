<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MonsterController;



Route::get('/', [PagesController::class, 'homeAction'])->name('home');


Route::get('/monster/{id}/{slug}', [MonsterController::class, 'show'])
    ->name('monster.show');
Route::get('/monsters', 
[MonsterController::class,'index'])
    ->name('monsters.index');
