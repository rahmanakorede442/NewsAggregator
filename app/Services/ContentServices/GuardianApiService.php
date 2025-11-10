<?php

declare(strict_types=1);

namespace App\Services\ContentServices;

use App\Interfaces\NewsServiceInterface;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GuardianApiService implements NewsServiceInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = (string) config('services.contents.guardian.key');
    }


    public function fetch() : array
    {

        $client = new Client();
        $url = "https://content.guardianapis.com/search";

        $response = $client->get($url, [
            "query" => [
                'api-key' => $this->apiKey,
                'show-fields' => 'thumbnail,trailText,headline',
                'show-references' => 'all',
                'page-size' => 100,
                'show-tags' => 'contributor',
                'from-date' => now()->subMonth()->toDateString(),
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return [];
        }

        $result = json_decode($response->getBody()->getContents(), true);
        $responseData = $result['response']['results'] ?? [];

        $normalized = array_map(function($item) {
            return [
                'source' => isset($item['references'][0]['id']) ? $item['references'][0]['id'] : null,
                'content_id' => $item['id'] ?? null,
                'title' => $item['webTitle'] ?? null,
                'thumbnail_url' => $item['fields']['thumbnail'] ?? null,
                'content' => $item['webTitle'] ?? null,
                'published_at' => isset($item['webPublicationDate']) ? Carbon::parse($item['webPublicationDate'])
                ->format('Y-m-d H:i:s') : null,
                'language' => 'en',
                'content_url' => $item['webUrl'] ?? null,
                'author' => $item['tags'][0]['webTitle'] ?? null,
                'category' => $item['sectionName'] ?? null,
            ];
        }, $responseData);

        return $normalized;
    }

}
