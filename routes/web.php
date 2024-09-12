<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyController;


Route::get('/', [FamilyController::class, 'index'])->name('families.index');
Route::resource('families', FamilyController::class);