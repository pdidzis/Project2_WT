<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Define the route for the homepage
Route::get('/', [HomeController::class, 'index']);
