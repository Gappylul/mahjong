<?php

use Illuminate\Support\Facades\Route;

if (app()->environment('production')) {
    URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});
