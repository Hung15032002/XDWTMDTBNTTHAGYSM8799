<?php

return [

    'default' => 'gmail', // Chọn tài khoản Gmail làm mặc định

    'accounts' => [
        'gmail' => [
            'host'          => 'imap.gmail.com',    // Host của IMAP Gmail
            'port'          => 993,                  // Cổng IMAP (Sử dụng cổng 993 cho SSL)
            'encryption'    => 'ssl',                // Mã hóa kết nối SSL
            'validate_cert' => true,                 // Kiểm tra chứng chỉ SSL
            'username'      => env('IMAP_USERNAME'), // Tài khoản Gmail của bạn
            'password'      => env('IMAP_PASSWORD'), // Mật khẩu ứng dụng của Gmail (app password nếu bật 2FA)
            'protocol'      => 'imap',               // Giao thức sử dụng là IMAP
        ],
    ],

    'options' => [
        'delimiter' => '/',         // Dấu phân cách thư mục trong IMAP
        'fetch' => 1,               // Fetch kiểu FT_PEEK (chỉ lấy header và body, không đánh dấu thư đã đọc)
        'fetch_body' => true,       // Lấy nội dung body của email
        'fetch_attachment' => true, // Lấy các tệp đính kèm (nếu có)
        'open' => [
            // Có thể thêm các cờ mở IMAP như "read-write" nếu cần
            'read-write' => true,    // Ví dụ: mở thư mục với quyền đọc và ghi
        ],
    ],
];
