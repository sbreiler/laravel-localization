<?php

return [
    'local' => env('app.locale', 'en_US'),
    'timezone' => env('app.timezone', 'America/Los_Angeles'),

    'currency' => [
        'model_cast' => ['currency','curr','c'],
        'default_currency_code' => 'USD'
    ],
    'date' => [
        'model_cast' => ['date','d']
    ],
    'number' => [
        'model_cast' => ['number','num','n']
    ]
];