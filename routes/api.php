<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('ensure-cookie')->group(function(){
    Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index']);

    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
    Route::get('/sources', [\App\Http\Controllers\SourcesController::class, 'index']);
    Route::get('/authors', [\App\Http\Controllers\AuthorController::class, 'index']);
    Route::get('/preferences', [\App\Http\Controllers\PreferenceController::class, 'index']);
    Route::post('/preferences', [\App\Http\Controllers\PreferenceController::class, 'store']);
});

