<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetNewsRequest;
use App\Models\Content;
use App\Models\VisitorPreference;
use App\Services\ContentServices\NewsAggregatorService;


class NewsController extends Controller
{

    public function __construct(protected NewsAggregatorService $newsApi)
    {}


    public function index(GetNewsRequest $request)
    {
        $visitorId = request('visitor_id');
        $date = request('date');
        $search = request('search');
        $category = request('category');
        $source = request('source');
        $author = request('author');

        $preferences = VisitorPreference::whereVisitorId($visitorId)->first();

        $response = Content::query()
        ->when(filled($date), fn($q) => $q->whereDate('published_at', '>=', $date))
        ->when(filled($search), function ($q) use ($search) {

            $q->where(function ($searchQuery) use ($search) {
                $searchQuery->where('source', 'like', "%$search%")
                ->orWhere('title', 'like', "%$search%")
                ->orWhere('author', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%")
                ->orWhere('category', 'like', "%$search%");
            });

        })->when(filled($category), fn($q) => $q->where('category', $category))
        ->unless(filled($category), function ($q) use ($preferences) {

            $categories = data_get($preferences, 'categories', []);
            if (!empty($categories)) $q->whereIn('category', $categories);

        })->when(filled($author), fn($q) => $q->where('author', $author))
        ->unless(filled($author), function ($q) use ($preferences) {

            $authors = data_get($preferences, 'authors', []);
            if (!empty($authors)) $q->whereIn('author', $authors);

        })->when(filled($source), fn($q) => $q->where('source', $source))
        ->unless(filled($source), function ($q) use ($preferences) {

            $sources = data_get($preferences, 'sources', []);
            if (!empty($sources)) $q->whereIn('source', $sources);

        })->latest()->paginate(20);

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $response
        ]);
    }
}
