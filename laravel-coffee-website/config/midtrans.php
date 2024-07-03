<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return[
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'merchant_key' => env('MIDTRANS_MERCHANT_ID'),
];
