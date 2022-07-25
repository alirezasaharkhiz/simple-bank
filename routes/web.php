<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dump(\App\Externals\helpers\Helper::generateCardNumber());
});
