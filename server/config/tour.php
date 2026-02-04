<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tour Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for tour management system
    |
    */

    'image' => [
        'max_size' => 2048, // KB
        'allowed_types' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
        'max_width' => 1200,
        'max_height' => 800,
        'quality' => 85,
        'folder' => 'tours',
    ],

    'pagination' => [
        'per_page' => 10,
        'max_per_page' => 100,
    ],

    'status' => [
        'tour' => [
            'active' => 'Đang hoạt động',
            'inactive' => 'Tạm ngưng',
            'completed' => 'Đã hoàn thành',
            'cancelled' => 'Đã hủy',
        ],
        'category' => [
            'active' => 'Đang hoạt động',
            'inactive' => 'Tạm ngưng',
        ],
    ],

    'validation' => [
        'tour_name_max_length' => 255,
        'location_max_length' => 255,
        'min_duration' => 1, // days
        'max_duration' => 365, // days
        'min_participants' => 1,
        'max_participants' => 1000,
        'min_price' => 0,
    ],

    'search' => [
        'min_query_length' => 2,
        'max_results' => 50,
    ],

    'cache' => [
        'ttl' => 3600, // seconds
        'keys' => [
            'categories' => 'tour_categories',
            'tours' => 'tour_list',
            'statistics' => 'tour_statistics',
        ],
    ],
];