<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MonsterController;



Route::get('/', [PagesController::class, 'homeAction'])->name('home');

Route::get('/monster/{id}/delete', [MonsterController::class, 'delete'])
    ->name('monster.delete');

Route::get('/monster/{id}/{slug}', [MonsterController::class, 'show'])
    ->name('monster.show');
Route::get('/monsters', 
[MonsterController::class,'index'])
    ->name('monsters.index');

Route::get('/monsters/create', [MonsterController::class, 'create'])
->name('monsters.create');

Route::post('/monsters', [MonsterController::class, 'store'])
->name('monsters.store');
