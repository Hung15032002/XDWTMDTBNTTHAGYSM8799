<?php

return [
    // Đường dẫn đến tệp credentials.json
    'credentials_path' => storage_path('credentials.json'),
    
    // URI chuyển hướng Google OAuth
    'redirect_uri' => env('GOOGLE_REDIRECT_URI', 'http://127.0.0.1:8000/oauth2callback'),
];
