<?php

namespace App\Http\Controllers;

use App\Models\Content;

class AuthorController extends Controller
{

    public function index()
    {
        $authors = Content::whereNotNull('author')
        ->where('author', '!=', '')
        ->distinct()
        ->pluck('author');

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $authors
        ], 200);
    }
}
