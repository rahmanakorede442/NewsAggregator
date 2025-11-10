<?php

declare(strict_types=1);

namespace App\Services\ContentServices;

use App\Models\Content;
use Illuminate\Support\Facades\Log;

class NewsAggregatorService
{

    protected array $newsServices;


    /**
     * @param  NewsServiceInterface[]  $sources
     */
    public function __construct(array $newsServices)
    {
        $this->newsServices = $newsServices;
    }

    public function aggregate()
    {
        try{
            foreach ($this->newsServices as $service) {

                $contents = $service->fetch();

                Content::upsert(
                    collect($contents)->toArray(),
                    ['url', 'content_id']
                );
            }

        } catch (\Exception $e) {
            Log::error("Failed to return contents from: " . get_class($service),
            [
                "error" => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
