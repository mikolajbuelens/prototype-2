<?php

use App\Http\Controllers\CrawlController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;



Route::get('/html', [ScrapeController::class, 'index'])->name('html');
//Route::get('/crawler', [ScrapeController::class, '__invoke'])->name('crawler');
//Route::get('/test', [ScrapeController::class, 'test'])->name('test');
//Route::get('/guzzle', [ScrapeController::class, 'scrape'])->name('scrape');
//Route::get('/guzzle', function (){
//    return view('scrape');
//});
Route::get('/', [ScrapeController::class, 'scrape']);
Route::get('/json', [ScrapeController::class, 'scrape2'])->name('json');
Route::get('/crawl', [CrawlController::class, 'crawl'])->name('crawl');



