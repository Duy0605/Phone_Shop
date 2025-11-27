<?php
/**
 * Utility Helper Functions
 * Các hàm tiện ích chung
 */

/**
 * Redirect đến URL
 * @param string $url URL cần redirect (có thể là relative hoặc absolute)
 * @param int $statusCode HTTP status code
 */
function redirect($url, $statusCode = 302)
{
    // Nếu là relative URL, thêm base_url
    if (strpos($url, 'http') !== 0) {
        $baseUrl = config('app.base_url', '');
        $url = rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
    }

    header("Location: {$url}", true, $statusCode);
    exit;
}

/**
 * Escape HTML để chống XSS
 * @param string $value
 * @return string
 */
function escape($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Lấy giá trị từ $_POST
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function post($key, $default = null)
{
    return $_POST[$key] ?? $default;
}

/**
 * Lấy giá trị từ $_GET
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function get($key, $default = null)
{
    return $_GET[$key] ?? $default;
}

/**
 * Lấy giá trị từ $_REQUEST
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function request($key, $default = null)
{
    return $_REQUEST[$key] ?? $default;
}

/**
 * Format giá tiền VND
 * @param numeric $price
 * @param bool $showCurrency
 * @return string
 */
function formatPrice($price, $showCurrency = true)
{
    // Handle null or empty values
    if ($price === null || $price === '') {
        $price = 0;
    }

    $formatted = number_format((float) $price, 0, ',', '.');

    return $showCurrency ? $formatted . 'đ' : $formatted;
}

/**
 * Format ngày tháng
 * @param string $date
 * @param string $format
 * @return string
 */
function formatDate($date, $format = 'd/m/Y')
{
    return date($format, strtotime($date));
}

/**
 * Format ngày giờ
 * @param string $datetime
 * @param string $format
 * @return string
 */
function formatDateTime($datetime, $format = 'd/m/Y H:i')
{
    return date($format, strtotime($datetime));
}

/**
 * Tạo slug từ chuỗi
 * @param string $str
 * @return string
 */
function createSlug($str)
{
    // Chuyển về chữ thường
    $str = mb_strtolower($str, 'UTF-8');

    // Bảng chuyển đổi ký tự có dấu
    $unicode = [
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
    ];

    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }

    // Xóa các ký tự đặc biệt
    $str = preg_replace('/[^a-z0-9\s-]/', '', $str);

    // Thay khoảng trắng và dấu gạch ngang liên tiếp bằng 1 dấu gạch ngang
    $str = preg_replace('/[\s-]+/', '-', $str);

    // Xóa dấu gạch ngang ở đầu và cuối
    $str = trim($str, '-');

    return $str;
}

/**
 * Upload file
 * @param array $file $_FILES['field_name']
 * @param string $destination Thư mục đích (relative to public/)
 * @param string $newName Tên file mới (không bao gồm extension)
 * @return array ['success' => bool, 'filename' => string, 'message' => string]
 */
function uploadFile($file, $destination = 'uploads/images', $newName = null)
{
    // Validate file
    $validation = validateFileUpload($file);
    if (!$validation['valid']) {
        return ['success' => false, 'filename' => '', 'message' => $validation['message']];
    }

    // Tạo tên file mới
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($newName === null) {
        $newName = uniqid() . '_' . time();
    }
    $filename = $newName . '.' . $extension;

    // Đường dẫn đầy đủ
    $publicPath = config('app.public_path', '');
    $uploadPath = $publicPath . '/' . trim($destination, '/');

    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    $fullPath = $uploadPath . '/' . $filename;

    // Di chuyển file
    if (move_uploaded_file($file['tmp_name'], $fullPath)) {
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $destination . '/' . $filename,
            'message' => 'Upload thành công'
        ];
    }

    return ['success' => false, 'filename' => '', 'message' => 'Lỗi khi upload file'];
}

/**
 * Xóa file
 * @param string $filePath Đường dẫn file (relative to public/)
 * @return bool
 */
function deleteFile($filePath)
{
    $publicPath = config('app.public_path', '');
    $fullPath = $publicPath . '/' . ltrim($filePath, '/');

    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }

    return false;
}

/**
 * Set flash message
 * @param string $type 'success', 'error', 'warning', 'info'
 * @param string $message
 */
function setFlashMessage($type, $message)
{
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get và xóa flash message
 * @return array|null ['type' => string, 'message' => string]
 */
function getFlashMessage()
{
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flash;
    }

    return null;
}

/**
 * Hiển thị flash message HTML
 * @return string
 */
function displayFlashMessage()
{
    $flash = getFlashMessage();

    if (!$flash) {
        return '';
    }

    $typeClass = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info'
    ];

    $class = $typeClass[$flash['type']] ?? 'alert-info';

    return sprintf(
        '<div class="alert %s alert-dismissible fade show" role="alert">
            %s
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>',
        $class,
        escape($flash['message'])
    );
}

/**
 * Lấy URL hiện tại
 * @return string
 */
function currentUrl()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Kiểm tra request method
 * @param string $method GET, POST, PUT, DELETE, etc.
 * @return bool
 */
function isMethod($method)
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($method);
}

/**
 * Debug - dump và die
 * @param mixed $data
 */
function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

/**
 * Lấy URL asset
 * @param string $path
 * @return string
 */
function asset($path)
{
    $assetsUrl = config('app.assets_url', '');
    return rtrim($assetsUrl, '/') . '/' . ltrim($path, '/');
}

/**
 * Lấy URL public
 * @param string $path
 * @return string
 */
function publicUrl($path)
{
    $baseUrl = config('app.base_url', '');
    return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
}

/**
 * Generate random string
 * @param int $length
 * @return string
 */
function randomString($length = 10)
{
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}

/**
 * Truncate text
 * @param string $text
 * @param int $length
 * @param string $ending
 * @return string
 */
function truncate($text, $length = 100, $ending = '...')
{
    if (mb_strlen($text) > $length) {
        return mb_substr($text, 0, $length - mb_strlen($ending)) . $ending;
    }

    return $text;
}

/**
 * Pagination helper
 * @param int $total Tổng số records
 * @param int $perPage Số records mỗi trang
 * @param int $currentPage Trang hiện tại
 * @return array ['total_pages', 'current_page', 'has_prev', 'has_next', 'prev_page', 'next_page']
 */
function paginate($total, $perPage, $currentPage = 1)
{
    $totalPages = ceil($total / $perPage);
    $currentPage = max(1, min($currentPage, $totalPages));

    return [
        'total' => $total,
        'per_page' => $perPage,
        'total_pages' => $totalPages,
        'current_page' => $currentPage,
        'has_prev' => $currentPage > 1,
        'has_next' => $currentPage < $totalPages,
        'prev_page' => $currentPage > 1 ? $currentPage - 1 : null,
        'next_page' => $currentPage < $totalPages ? $currentPage + 1 : null,
        'offset' => ($currentPage - 1) * $perPage
    ];
}
