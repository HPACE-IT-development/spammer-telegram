<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', \App\Livewire\Login::class);
Route::get('/logout', \App\Livewire\Logout::class);
Route::get('/my-bots', \App\Livewire\MyBots::class);
Route::get('/newsletter', \App\Livewire\Newsletter::class);

Route::get('/bots', \App\Livewire\N\Bots::class);
Route::get('/jobs', \App\Livewire\N\Action\ActionIndex::class);