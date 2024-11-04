<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
//use Spatie\Crawler\Crawler;
use App\Observers\ScraperObserver;
use App\Http\Controllers\Controller;
use Symfony\Component\DomCrawler\Crawler;
//use Spatie\Crawler\CrawlProfiles\CrawlProfile;




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
//        Will display all the html from the Torfs website
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://www.torfs.be/nl/heren/schoenen/sneakers/?cgid=Heren-Schoenen-Sneakers&sz=862');
//        echo $res->getBody();
      $html =  (string)$res->getBody();
        $crawler = new Crawler($html);

// Example: Find all product titles
        $products = $crawler->filter('.product-tile')->each(function (Crawler $node, $i) {
            $value = $node->filter('.value')->text();
            $name = $node->filter('.pdp-link')->text();
//            $image = $node->filter('.tile-image')->text();
          $image =  ($node->filter('.tile-image')->attr('src'));
          if(str_contains($image, "data:image/gif") ) {
              $image = $node->filter('.tile-image')->attr('data-src');
          }
//            $lazyLoadedImage = $node->filter('.tile-image')->attr('data-src');

//            decode src="data:image/gif;base64
//            $image = base64_decode($node->filter('.tile-image')->attr('src'));


            return [
                'name' => $name,
                'value' => $value,
                'image' => $image,
//                'lazyLoadedImage' => $lazyLoadedImage
               ];

        });


//    dd($products);
        return view('scrape', compact('products'));

//        $products = $crawler->filter('.product-tile')->each(function (Crawler $node) {
//            $title = $node->filter('.product-name')->text();
//            $price = $node->filter('.price')->text();
//            return [
//                'title' => $title,
//                'price' => $price,
//            ];
//        });


//        Crawler::create()
//            ->setCrawlObserver(new ScraperObserver())
//            ->startCrawling('https://www.torfs.be/nl/home?gad_source=1&gclid=CjwKCAjwpbi4BhByEiwAMC8JnZ0bD-Zfo1Zd9bpuALKpb3Sdzl5P9UXxu88Wuwdg-wbBYHjfkfi03xoC96YQAvD_BwE');


//        $html = (string)$res->getBody();
////        parse with regex (Shouldn't be done on html)
////        filter on class
//        $pattern = '/<div\s+class="product-tile__image">([\s\S]+?)<\/div>/i';
//        preg_match($pattern, $html, $matches);
//        dd($matches);


//  try parsing with DOMDocument

//        $dom = new DOMDocument();
//        @$dom->loadHTML($html);
//        $tags = $dom->getElementsByTagName('div');

//        $array = array();
//        foreach ($tags as $tag) {
//            $array[] = $tag->nodeValue;
//        }
//        return response()->json([
//            'data' => $html,
//            'divs' => $array,
//            'message' => 'test'
//        ]);

//        $pattern = '/<div\s+class="product-tile__image">([\s\S]+?)<\/div>/i';
//        preg_match($pattern, $html, $matches);
//      echo $html;
    }

//    return all html content from the torfs website
    public function scrape2(){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://www.torfs.be/nl/heren/schoenen/sneakers/');
        echo $res->getBody();

    }


    public function  shouldCrawl(UriInterface $url): bool
    {
        return true;
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



