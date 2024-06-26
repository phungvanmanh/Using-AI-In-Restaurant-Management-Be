<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', '*'],  // Đường dẫn nào cần CORS, 'api/*' là phổ biến cho các ứng dụng API
    'allowed_methods' => ['*'],  // Phương thức nào được phép
    'allowed_origins' => ['*'],  // Nguồn gốc nào được phép, '*' nghĩa là tất cả
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,  // Đặt true nếu bạn cần hỗ trợ cookies

];
