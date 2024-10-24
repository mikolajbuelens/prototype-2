<?php

use App\Http\Controllers\CrawlController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;



Route::get('/', [ScrapeController::class, 'index']);
//Route::get('/crawler', [ScrapeController::class, '__invoke'])->name('crawler');
//Route::get('/test', [ScrapeController::class, 'test'])->name('test');
//Route::get('/guzzle', [ScrapeController::class, 'scrape'])->name('scrape');
//Route::get('/guzzle', function (){
//    return view('scrape');
//});
Route::get('/scrape', [ScrapeController::class, 'scrape'])->name('scrape');
Route::get('/scrape2', [ScrapeController::class, 'scrape2'])->name('scrape2');
Route::get('/crawl', [CrawlController::class, 'crawl'])->name('crawl');



