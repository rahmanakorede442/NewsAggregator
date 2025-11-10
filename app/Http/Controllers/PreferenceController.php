<?php

namespace App\Http\Controllers;

use App\Models\VisitorPreference;
use Illuminate\Http\JsonResponse;

class PreferenceController extends Controller
{
    public function index() : JsonResponse
    {
        $visitorId = request('visitor_id');
        $preferences = VisitorPreference::query()->whereVisitorId($visitorId)->first();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $preferences ?? []
        ], 200);

    }

    public function store() : JsonResponse
    {
        $visitorId = request('visitor_id');
        $preference = VisitorPreference::whereVisitorId($visitorId)->first();

        $categories = (array) request('categories', []);
        $authors = (array) request('authors', []);
        $sources = (array) request('sources', []);

        $preference->categories = array_values(array_unique(array_merge((array) $preference->categories, $categories)));
        $preference->authors = array_values(array_unique(array_merge((array) $preference->authors, $authors)));
        $preference->sources = array_values(array_unique(array_merge((array) $preference->sources, $sources)));
        $preference->save();

        return response()->json([
            "status" => true,
            "message" => "Preference saved!",
        ], 200);
    }
}
