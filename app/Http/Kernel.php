<?php

namespace Http;

/**
 * Kernel
 * Route dispatcher - Xử lý routing và dispatch request đến Controller
 */
class Kernel
{
    protected $routes = [];
    protected $method;
    protected $uri;

    public function __construct()
    {
        // Load routes từ file web.php
        $this->routes = require __DIR__ . '/../../routes/web.php';

        // Lấy HTTP method
        $this->method = $_SERVER['REQUEST_METHOD'];

        // Lấy URI và làm sạch
        $this->uri = $this->getUri();
    }

    /**
     * Lấy URI từ request
     * @return string
     */
    protected function getUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Xóa query string (?param=value)
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        // Xóa base path nếu app không ở root
        // Ví dụ: /Phone_Shop/public/products -> /products
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        $baseDir = str_replace('\\', '/', dirname($scriptName));

        // Chỉ xử lý nếu baseDir không phải là root
        if ($baseDir !== '/' && $baseDir !== '') {
            // Nếu URI bắt đầu với baseDir, xóa nó
            if (strpos($uri, $baseDir) === 0) {
                $uri = substr($uri, strlen($baseDir));
            }
        }

        // Đảm bảo URI bắt đầu bằng /
        $uri = '/' . trim($uri, '/');

        // Nếu URI là /index.php thì chuyển thành /
        if ($uri === '/index.php') {
            $uri = '/';
        }

        return $uri;
    }

    /**
     * Dispatch request đến controller
     * @return void
     */
    public function dispatch()
    {
        // Kiểm tra route tồn tại không
        if (!isset($this->routes[$this->method])) {
            $this->notFound();
            return;
        }

        $matchedRoute = $this->matchRoute($this->routes[$this->method]);

        if ($matchedRoute === false) {
            $this->notFound();
            return;
        }

        // Parse controller và action
        list($controllerName, $action) = explode('@', $matchedRoute['handler']);

        // Xử lý namespace cho controller
        if (strpos($controllerName, '\\') === false) {
            // Nếu không có namespace, thêm Controllers\
            $controllerClass = 'Controllers\\' . $controllerName;
        } else {
            // Nếu có namespace (Admin\...), giữ nguyên
            $controllerClass = 'Controllers\\' . $controllerName;
        }

        // Kiểm tra controller tồn tại
        if (!class_exists($controllerClass)) {
            die("Controller không tồn tại: {$controllerClass}");
        }

        // Khởi tạo controller
        $controller = new $controllerClass();

        // Kiểm tra method tồn tại
        if (!method_exists($controller, $action)) {
            die("Method không tồn tại: {$action} trong {$controllerClass}");
        }

        // Gọi controller method với parameters
        call_user_func_array([$controller, $action], $matchedRoute['params']);
    }

    /**
     * Match URI với routes đã định nghĩa
     * @param array $routes
     * @return array|false
     */
    protected function matchRoute($routes)
    {
        foreach ($routes as $pattern => $handler) {
            // Chuyển pattern thành regex
            // Ví dụ: /product/{slug} -> /product/([^/]+)
            $regex = $this->convertToRegex($pattern);

            if (preg_match($regex, $this->uri, $matches)) {
                // Loại bỏ match đầu tiên (toàn bộ string)
                array_shift($matches);

                return [
                    'handler' => $handler,
                    'params' => $matches
                ];
            }
        }

        return false;
    }

    /**
     * Chuyển đổi pattern route thành regex
     * @param string $pattern
     * @return string
     */
    protected function convertToRegex($pattern)
    {
        // Thay thế {param} bằng regex capture group trước
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $pattern);

        // Escape các ký tự đặc biệt (ngoại trừ các capture groups)
        $pattern = str_replace('/', '\/', $pattern);

        // Thêm ^ và $ để match chính xác
        return '/^' . $pattern . '$/';
    }

    /**
     * Xử lý 404 Not Found
     * @return void
     */
    protected function notFound()
    {
        http_response_code(404);

        // Kiểm tra có file 404 custom không
        $notFoundPage = __DIR__ . '/../../resources/view/errors/404.php';

        if (file_exists($notFoundPage)) {
            require $notFoundPage;
        } else {
            // Fallback 404 page
            echo '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .container {
            text-align: center;
            padding: 2rem;
        }
        h1 {
            font-size: 8rem;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        h2 {
            font-size: 2rem;
            margin: 1rem 0;
        }
        p {
            font-size: 1.2rem;
            margin: 1rem 0 2rem;
        }
        a {
            display: inline-block;
            padding: 1rem 2rem;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: transform 0.3s;
        }
        a:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Không tìm thấy trang</h2>
        <p>Trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
        <a href="' . config('app.base_url') . '">Về Trang Chủ</a>
    </div>
</body>
</html>';
        }

        exit;
    }

    /**
     * Run application
     * @return void
     */
    public function run()
    {
        $this->dispatch();
    }
}
