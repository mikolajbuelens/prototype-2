<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;



Route::get('/', [ScrapeController::class, 'index']);
Route::get('/crawler', [ScrapeController::class, '__invoke'])->name('crawler');
Route::get('/test', [ScrapeController::class, 'test'])->name('test');

