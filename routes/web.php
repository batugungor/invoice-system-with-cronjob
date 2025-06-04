<?php

use App\Enums\InvoiceStatus;
use App\Enums\SubscriptionBillingCycle;
use App\Enums\SubscriptionStatus;
use App\Models\Invoice;
use App\Models\InvoiceLineItem;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use App\Services\DiscordWebhooks\InvoiceWebhooks;
use App\Services\Subscription\CalculateDateBySubscriptionBillingCycle;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/maak', function () {

});
