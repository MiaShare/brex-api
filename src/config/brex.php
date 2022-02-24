<?php

/*
 * Default configuration to run the brex.com API
 */
return [
    'url'       => env('BREX_API_URL', 'https://platform.brexapis.com'),
    'api_token' => env('BREX_TOKEN'),
];