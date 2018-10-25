<?php

return [
    'show-current-category-selected' => 1,
    'show-parent-category-selected' => 2,
    
    'CRON_EMAIL' => env('CRON_EMAIL', ''),
    'INFO_EMAIL' => env('INFO_EMAIL', ''),
    'NOREPLAY_EMAIL' => env('NOREPLAY_EMAIL', ''),


    'APP_NAME' => env('APP_NAME', 'No Name set'),
    'DEFAULT_LOCALE' => env('DEFAULT_LOCALE', 'en'),
    'PAGINATE_PER_PAGE' => env('PAGINATE_PER_PAGE', 10),
    'SELECTED_COUNTRY_ID' => env('SELECTED_COUNTRY_ID', 0),
    'SELECTED_FIRST_LEVEL_CATEGORY_ID' => env('SELECTED_FIRST_LEVEL_CATEGORY_ID', 0),
    'SELECTED_SECOND_LEVEL_CATEGORY_ID' => env('SELECTED_SECOND_LEVEL_CATEGORY_ID', 0),
];