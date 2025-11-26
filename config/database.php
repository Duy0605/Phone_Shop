<?php
/**
 * Database Configuration
 * Cấu hình kết nối cơ sở dữ liệu MySQL
 */

return [
    // Thông tin kết nối database
    'host' => 'localhost',
    'port' => 3307,
    'database' => 'phone_shop',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',

    // Cấu hình bổ sung
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
