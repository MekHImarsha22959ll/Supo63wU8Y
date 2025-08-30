<?php
// 代码生成时间: 2025-08-30 19:56:21
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WebContentScraper {
    /**
     * HTTP client for making requests
     *
     * @var Client
     */
    private $client;

    /**
     * Constructor
     *
     * @param Client $client The HTTP client instance
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Scrape content from a given URL
     *
     * @param string $url The URL to scrape content from
     * @return string|null The scraped content or null if an error occurs
     */
    public function scrapeContent($url) {
        try {
            // Make a GET request to the URL
            $response = $this->client->get($url);

            // Check if the request was successful
            if ($response->getStatusCode() === 200) {
                // Return the response body as a string
                return $response->getBody()->getContents();
            } else {
                // Log an error if the request was not successful
                Log::error("Failed to scrape content from {$url}: HTTP status code " . $response->getStatusCode());
                return null;
            }
        } catch (Exception $e) {
            // Log any exceptions that occur during the request
            Log::error("Error scraping content from {$url}: " . $e->getMessage());
            return null;
        }
    }
}

// Usage example
// $client = new Client();
// $scraper = new WebContentScraper($client);
// $content = $scraper->scrapeContent("https://example.com");
// if ($content !== null) {
//     echo $content;
// } else {
//     echo "Failed to scrape content.";
// }