<?php

use App\Http\Controllers\ZohoAPI\AccountController;
use App\Http\Controllers\ZohoAPI\DealController;
use Illuminate\Support\Facades\Route;

Route::post('/account/create', [AccountController::class, 'createAccount']);
Route::post('/deal/create', [DealController::class, 'createDeal']);

