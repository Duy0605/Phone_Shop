<?php
/**
 * Autoloader
 * Tự động load các class khi cần thiết (PSR-4 style)
 */

// Bật hiển thị lỗi (chỉ dùng khi development)
if (file_exists(__DIR__ . '/config/app.php')) {
    $appConfig = require __DIR__ . '/config/app.php';
    if ($appConfig['debug']) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

// Autoloader function
spl_autoload_register(function ($class) {
    // Namespace mapping
    $namespaceMap = [
        'Controllers\\' => __DIR__ . '/app/Http/Controllers/',
        'Models\\' => __DIR__ . '/app/Models/',
        'Middleware\\' => __DIR__ . '/app/Http/Middleware/',
        'Http\\' => __DIR__ . '/app/Http/',
    ];

    // Tìm mapping phù hợp
    foreach ($namespaceMap as $prefix => $baseDir) {
        // Kiểm tra class có bắt đầu với prefix không
        if (strpos($class, $prefix) === 0) {
            // Lấy phần còn lại của class name
            $relativeClass = substr($class, strlen($prefix));

            // Tạo đường dẫn file
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            // Nếu file tồn tại, require nó
            if (file_exists($file)) {
                require $file;
                return true;
            }
        }
    }

    // Fallback: thử load trực tiếp từ app/
    $file = __DIR__ . '/app/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }

    return false;
});

// Load các helper functions
$helperFiles = [
    __DIR__ . '/app/Helper/auth.php',
    __DIR__ . '/app/Helper/utils.php',
    __DIR__ . '/app/Helper/validation.php',
];

foreach ($helperFiles as $file) {
    if (file_exists($file)) {
        require_once $file;
    }
}

// Load config files
function config($key, $default = null)
{
    static $config = [];

    // Parse key (ví dụ: 'database.host' hoặc 'app.name')
    $parts = explode('.', $key);
    $file = $parts[0];

    // Load config file nếu chưa load
    if (!isset($config[$file])) {
        $configFile = __DIR__ . '/config/' . $file . '.php';
        if (file_exists($configFile)) {
            $config[$file] = require $configFile;
        } else {
            return $default;
        }
    }

    // Lấy giá trị từ config
    $value = $config[$file];

    // Nếu có nested key (ví dụ: 'database.host')
    for ($i = 1; $i < count($parts); $i++) {
        if (!isset($value[$parts[$i]])) {
            return $default;
        }
        $value = $value[$parts[$i]];
    }

    return $value;
}

// Set timezone
date_default_timezone_set(config('app.timezone', 'Asia/Ho_Chi_Minh'));

// Khởi tạo session
if (session_status() === PHP_SESSION_NONE) {
    $sessionConfig = config('app.session', []);

    // Cấu hình session
    if (isset($sessionConfig['name'])) {
        session_name($sessionConfig['name']);
    }

    if (isset($sessionConfig['lifetime'])) {
        ini_set('session.gc_maxlifetime', $sessionConfig['lifetime']);
        session_set_cookie_params($sessionConfig['lifetime']);
    }

    if (isset($sessionConfig['httponly'])) {
        ini_set('session.cookie_httponly', $sessionConfig['httponly']);
    }

    if (isset($sessionConfig['samesite'])) {
        ini_set('session.cookie_samesite', $sessionConfig['samesite']);
    }

    session_start();
}
