<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperheroController;

Route::get('/', function () {
    return redirect()->route('superheroes.index');
});

// Custom routes first to avoid collision with resource {superhero}
Route::get('superheroes/trashed', [SuperheroController::class, 'trashed'])->name('superheroes.trashed');
Route::post('superheroes/{id}/restore', [SuperheroController::class, 'restore'])->name('superheroes.restore');
Route::delete('superheroes/{id}/force-delete', [SuperheroController::class, 'forceDelete'])->name('superheroes.forceDelete');

// Then the resource (will not capture 'trashed' anymore)
Route::resource('superheroes', SuperheroController::class);
