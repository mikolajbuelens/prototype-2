<?php

namespace App\Observers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class ScraperObserver extends \Spatie\Crawler\CrawlObservers\CrawlObserver
{
    private $content;

    public function __construct()
    {
        $this->content = [];
    }

    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
        Log::info('willCrawl', ['url' => (string) $url]);
    }

    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        Log::info("Crawled: {$url}");
    }
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        Log::error("Failed: {$url}");
    }

    /*
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        Log::info("Finished crawling");
    }
}
