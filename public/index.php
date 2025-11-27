<?php
/**
 * Front Controller - Entry Point
 * Điểm khởi đầu cho tất cả các requests
 */

// Start session
session_start();

// Require autoloader
require_once __DIR__ . '/../autoload.php';

// Load HTTP Kernel
require_once __DIR__ . '/../app/Http/Kernel.php';

// Khởi tạo và chạy application
$kernel = new Http\Kernel();
$kernel->run();
