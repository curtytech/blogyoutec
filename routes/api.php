<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;


Route::get('posts', [PostController::class, 'index']);
Route::get('post/{slug}', [PostController::class, 'show']); 
