<?php

declare(strict_types=1);

namespace App\Services\ContentServices;

use App\Interfaces\NewsServiceInterface;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class NewsApiService implements NewsServiceInterface
{
    protected string $apiKey;

    public function __construct() {
        $this->apiKey = config('services.contents.news-api.key');
    }

    public function fetch() : array
    {

        $client = new Client();
        $url = "https://newsapi.org/v2/everything";

        $response = $client->get($url, [
            "query" => [
                "q" => "a",
                "from"  => now()->subMonth()->toDateString(),
                "sortBy" => "publishedAt",
                "language" => "en",
                "apiKey" => $this->apiKey
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return [];
        }

        $result = json_decode($response->getBody()->getContents(), true);
        $responseData = $result['articles'] ?? [];

        $normalized = array_map(function($item) {
            return [
                'source' => $item['source']['name'] ?? 'newsApi',
                'content_id' => $item['url'] ?? null,
                'title' => $item['title'] ?? null,
                'thumbnail_url' => $item['urlToImage'] ?? null,
                'content' => $item['description'] ?: null,
                'published_at' => isset($item['published_at']) ? Carbon::parse($item['published_at'])->format('Y-m-d H:i:s') : null,
                'language' => 'en',
                'content_url' => $item['url'] ?? null,
                'author' => $item['author'] ?? null,
                'category' => null,
            ];
        }, $responseData);

        return $normalized;
    }
}
