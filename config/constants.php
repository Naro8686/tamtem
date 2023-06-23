<?php

return [
    'email' => [
        'noreply' => env('EMAIL_NOREPLY', 'noreply@tamtem.ru'),
    ],
    'tamtem' => [
        'url' => env('TAMTEM_URL', 'https://tamtem.ru'),
        'statistic-api' => env('TAMTEM_STATISTIC_API_URL', 'https://tamtem.ru/api/v1/ref/api/getstatistic'),
        'inn-is-available-api' => env('TAMTEM_INN_IS_AVAILABLE_API_URL', 'https://tamtem.ru/api/v1/ref/api/innisavailable'),
    ],
];