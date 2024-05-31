<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\IntrospectionController;

Route::post('api/v1/oauth/introspect', IntrospectionController::class)->name('oauth.introspect');



