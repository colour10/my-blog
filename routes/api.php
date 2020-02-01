<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->namespace('Api')->name('api.')->group(function () {
    Route::get('test', function () {
        return 'test';
    })->name('test');
});

