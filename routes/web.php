<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'API Laravel Backend',
        'version' => '1.0',
        'status' => 'online',
        'endpoints' => [
            'api' => '/api/v1',
            'health' => '/up',
        ],
    ]);
});
