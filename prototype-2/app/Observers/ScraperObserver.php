<?php

namespace App\Observers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use App\Http\Controllers\Controller;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;



class ScraperObserver extends CrawlObserver
{
    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
        dd('willCrawl', ['url' => (string) $url]);
    }

    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null
    ): void {
        $html = (string) $response->getBody();
        $crawler = new DomCrawler($html);

        try {
            // Extract the product name
            $name = $crawler->filter('.pdp-link a')->first()->text();
            dd('Product Name: ' . $name);
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

class ScrapeController extends Controller
{
    public function __invoke()
    {
        $url = "https://www.torfs.be/nl/heren/schoenen/sneakers/?cgid=Heren-Schoenen-Sneakers&page=1.0&srule=nieuwste&sz=24";
        Crawler::create()
            ->setCrawlObserver(new ScraperObserver())
            ->setMaximumDepth(0)
            ->setTotalCrawlLimit(1)
            ->setDelayBetweenRequests(500)  // Add delay if the site rate-limits
            ->setConnectionTimeout(10)      // Increase timeout
            ->startCrawling($url);
    }
}
