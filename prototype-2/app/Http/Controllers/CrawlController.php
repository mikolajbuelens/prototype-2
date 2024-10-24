<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
//use App\Observers\CrawlObserver;
use App\Observers\ScraperObserver;
use Illuminate\Http\Request;
use Spatie\Crawler\Crawler;


// Spatie/Crawler Github repo => https://github.com/spatie/crawler
class CrawlController extends Controller
{
    function crawl(){
$url = "https://www.torfs.be/nl/heren/schoenen/sneakers/";
        Crawler::create()
            ->setCrawlObserver(new ScraperObserver())
    ->startCrawling($url);
    }
}
