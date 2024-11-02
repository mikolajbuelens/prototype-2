<?php

namespace App\Observers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use App\Http\Controllers\Controller;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;



class ScraperObserver extends CrawlObserver
{
    public function willCrawl(UriInterface $url, ?string $linkText): void
    {

//        dd('willCrawl', ['url' => (string) $url]);
    }

//    TODO: try to scrape the detail page of each shoe (i.e. with description, colors,...)

    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null
    ): void {
        $html = (string) $response->getBody();
        $crawler = new DomCrawler($html);

        try {
//            $shoes = [];
            // Extract the product name
            $shoes = $crawler->filter('.product-tile')->each(function (Crawler $node) use(&$shoes) {
                $value = $node->filter('.value')->text();
                $name = $node->filter('.pdp-link')->text();
                $image = $node->filter('.tile-image')->text();
               $shoes[] = [
                    'name' => $name,
                    'value' => $value,
                    'image' => $image,
                ];

//                return view('scrape', compact('shoes'));
//dd($shoes);
            });

        } catch (\Exception $e) {
            dd('Failed to extract name: ' . $e->getMessage());
        }
    }

    public function crawlFailed(
        UriInterface $url,
        \GuzzleHttp\Exception\RequestException $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null
    ): void {
        dd("Failed: {$url}");
    }

    public function finishedCrawling(): void
    {
        dd("Finished crawling");
    }

}
