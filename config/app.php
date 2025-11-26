<?php
/**
 * Application Configuration
 * Cấu hình chung cho ứng dụng
 */

return [
    // Thông tin ứng dụng
    'name' => 'Phone Shop',
    'version' => '1.0.0',

    // URL cơ bản
    'base_url' => 'http://localhost/Phone_Shop/Phone_Shop/public',
    'assets_url' => 'http://localhost/Phone_Shop/Phone_Shop/resources',

    // Đường dẫn thư mục
    'root_path' => dirname(__DIR__),
    'app_path' => dirname(__DIR__) . '/app',
    'public_path' => dirname(__DIR__) . '/public',
    'resources_path' => dirname(__DIR__) . '/resources',
    'upload_path' => dirname(__DIR__) . '/public/uploads',

    // Cấu hình session
    'session' => [
        'name' => 'phone_shop_session',
        'lifetime' => 7200, // 2 giờ (tính bằng giây)
        'secure' => false, // Set true nếu dùng HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ],

    // Cấu hình bảo mật
    'security' => [
        'password_min_length' => 6,
        'password_hash_algo' => PASSWORD_BCRYPT,
        'password_hash_cost' => 10
    ],

    // Cấu hình upload file
    'upload' => [
        'max_size' => 5242880, // 5MB (tính bằng bytes)
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'image_path' => 'uploads/images'
    ],

    // Cấu hình phân trang
    'pagination' => [
        'per_page' => 12, // Số sản phẩm mỗi trang
        'per_page_admin' => 20 // Số item mỗi trang trong admin
    ],

    // Múi giờ
    'timezone' => 'Asia/Ho_Chi_Minh',

    // Chế độ debug (bật khi development, tắt khi production)
    'debug' => true,

    // Cấu hình email (để sau này mở rộng)
    'mail' => [
        'from_email' => 'noreply@phoneshop.com',
        'from_name' => 'Phone Shop'
    ]
];
