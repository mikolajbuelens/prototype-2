<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\Crawler;
use App\Observers\ScraperObserver;
use App\Http\Controllers\Controller;


//Crawler::create()
//    ->setCrawlObserver(new ScraperObserver())
//    ->startCrawling('https://www.torfs.be/nl/home?gad_source=1&gclid=CjwKCAjwpbi4BhByEiwAMC8JnZ0bD-Zfo1Zd9bpuALKpb3Sdzl5P9UXxu88Wuwdg-wbBYHjfkfi03xoC96YQAvD_BwE');

class ScrapeController extends Controller
{


// testing out a simpler method with guzzle
// Seems to be working fine
// TODO: compare with spatie/crawler method
    function scrape()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://www.torfs.be/nl/heren/schoenen/sneakers/?cgid=Heren-Schoenen-Sneakers&page=1.0&srule=nieuwste&sz=24');
        echo $res->getBody();
    }


////    testing out spatie/crawler
    public function __invoke(Request $request)
    {
     $url ="https://www.torfs.be/nl/heren/schoenen/sneakers/?cgid=Heren-Schoenen-Sneakers&page=1.0&srule=nieuwste&sz=24";
        Crawler::create()
            ->setCrawlObserver(new ScraperObserver())
            ->setMaximumDepth(0)  // 0 -> only the first url will be crawled
            ->setTotalCrawlLimit(1) // maximum number of urls to crawl
            ->startCrawling($url);

    }

    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        Log::info("Crawled: {$url}");
        $crawler = new Crawler((string) $response->getBody());
//        Required class = pdp-link
      $price =  $crawler->filter('a')->each(function (Crawler $node) {
          return str_contains($node->text(), 'adidas'); // php's needle and haystack
        })->nextAll()->filter('.value')->first()
            ->text();
        dd($price);


    }


//    basic scrapping function with plain php
    public function index() : JsonResponse
    {

// get HTMl content and convert it to array in JSON format
$url = "https://www.torfs.be/nl/heren/schoenen/sneakers/?cgid=Heren-Schoenen-Sneakers&page=1.0&srule=nieuwste&sz=24";
$html = file_get_contents($url);
$array = array();
$dom = new DOMDocument();
@$dom->loadHTML($html);
$tags = $dom->getElementsByTagName('div');


// parse the HTML
foreach ($tags as $tag) {
    $array[] = $tag->nodeValue;
}

        return response()->json([
            'data' => $html,
            'divs' => $array,
            'message' => 'test'
        ]);
    }
}



