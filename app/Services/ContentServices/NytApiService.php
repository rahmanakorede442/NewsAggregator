<?php

declare(strict_types=1);

namespace App\Services\ContentServices;

use App\Interfaces\NewsServiceInterface;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class NytApiService implements NewsServiceInterface
{

    protected string $apiKey;

    public function __construct() {
        $this->apiKey = config('services.contents.nyt.key');
    }



    public function fetch() : array
    {
        $client = new Client();
        $url = "https://api.nytimes.com/svc/news/v3/content/all/all.json";

        $response = $client->get($url, [
            "query" => [
                "api-key" => $this->apiKey
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return [];
        }

        $result = json_decode($response->getBody()->getContents(), true);
        $responseData = $result['results'] ?? [];

        $normalized = array_map(function($item) {
            return [
                'source' => $item['source'] ?? 'NewYork Times',
                'content_id' => $item['slug_name'] ?? null,
                'title' => $item['title'] ?? null,
                'thumbnail_url' => isset($item['multimedia'][0]['url']) ? $item['multimedia'][0]['url'] : null,
                'content' => $item['abstract'] ?: null,
                'published_at' => isset($item['published_date']) ? Carbon::parse($item['published_date'])
                ->format('Y-m-d H:i:s') : null,
                'language' => 'en',
                'content_url' => $item['url'] ?? null,
                'author' => $item['author'] ?? null,
                'category' => $item['subsection'] ?: $item['section'],
            ];
        }, $responseData);

        return $normalized;

    }
}
