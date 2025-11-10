<?php

namespace App\Http\Controllers;

use App\Models\Content;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Content::distinct()
        ->whereNotNull('category')
        ->where('category', '!=', '')
        ->pluck('category');

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $categories
        ], 200);
    }

}
