<?php

/*
 * Default configuration to run the brex.com API
 */
return [
    'url' => env('BREX_API_URL', 'https://platform.brexapis.com'),
    'secret' => env('BREX_TOKEN'),
];