<?php

use Illuminate\Support\Facades\Route;

Route::resource('superheroes', 'SuperheroController');
Route::get('/', function () { return redirect()->route('superheroes.index'); });