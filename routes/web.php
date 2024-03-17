<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', \App\Livewire\Login::class);
Route::get('/my-bots', \App\Livewire\MyBots::class);
Route::get('/newsletter', \App\Livewire\Newsletter::class);
Route::get('/bots', \App\Livewire\N\Bot\BotIndex::class);
