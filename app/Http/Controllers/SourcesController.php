<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class SourcesController extends Controller
{

    public function index()
    {
        $sources = Content::distinct()
        ->whereNotNull('source')
        ->where('source', '!=', '')
        ->pluck('source');

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $sources
        ], 200);
    }
}
