<?php
/**
 * Auth Helper Functions
 * Các hàm hỗ trợ xác thực và phân quyền người dùng
 */

/**
 * Đăng nhập người dùng
 * @param array $user Thông tin user từ database
 */
function login($user)
{
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['logged_in'] = true;
}

/**
 * Đăng xuất người dùng
 */
function logout()
{
    // Xóa tất cả session variables
    $_SESSION = [];

    // Xóa session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // Hủy session
    session_destroy();
}

/**
 * Kiểm tra user đã đăng nhập chưa
 * @return bool
 */
function isAuthenticated()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Kiểm tra user có phải admin không
 * @return bool
 */
function isAdmin()
{
    return isAuthenticated() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Kiểm tra user có phải customer không
 * @return bool
 */
function isCustomer()
{
    return isAuthenticated() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer';
}

/**
 * Lấy ID của user hiện tại
 * @return int|null
 */
function getUserId()
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Lấy tên của user hiện tại
 * @return string|null
 */
function getUserName()
{
    return $_SESSION['user_name'] ?? null;
}

/**
 * Lấy email của user hiện tại
 * @return string|null
 */
function getUserEmail()
{
    return $_SESSION['user_email'] ?? null;
}

/**
 * Lấy role của user hiện tại
 * @return string|null
 */
function getUserRole()
{
    return $_SESSION['user_role'] ?? null;
}

/**
 * Lấy tất cả thông tin user hiện tại
 * @return array|null
 */
function getCurrentUser()
{
    if (!isAuthenticated()) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'] ?? null,
        'name' => $_SESSION['user_name'] ?? null,
        'email' => $_SESSION['user_email'] ?? null,
        'role' => $_SESSION['user_role'] ?? null,
    ];
}

/**
 * Yêu cầu đăng nhập (middleware-like)
 * Redirect về trang login nếu chưa đăng nhập
 * @param string $redirectTo URL redirect sau khi login
 */
function requireAuth($redirectTo = null)
{
    if (!isAuthenticated()) {
        // Lưu URL hiện tại để redirect lại sau khi login
        if ($redirectTo) {
            $_SESSION['redirect_after_login'] = $redirectTo;
        }

        redirect('/login');
        exit;
    }
}

/**
 * Yêu cầu quyền admin
 * Redirect về trang chủ nếu không phải admin
 */
function requireAdmin()
{
    requireAuth();

    if (!isAdmin()) {
        setFlashMessage('error', 'Bạn không có quyền truy cập trang này!');
        redirect('/');
        exit;
    }
}

/**
 * Lấy URL redirect sau khi login
 * @return string|null
 */
function getRedirectAfterLogin()
{
    if (isset($_SESSION['redirect_after_login'])) {
        $url = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']);
        return $url;
    }

    return null;
}

/**
 * Hash mật khẩu
 * @param string $password
 * @return string
 */
function hashPassword($password)
{
    $algo = config('app.security.password_hash_algo', PASSWORD_BCRYPT);
    $cost = config('app.security.password_hash_cost', 10);

    return password_hash($password, $algo, ['cost' => $cost]);
}

/**
 * Verify mật khẩu
 * @param string $password Mật khẩu người dùng nhập
 * @param string $hash Hash từ database
 * @return bool
 */
function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

/**
 * Generate CSRF token
 * @return string
 */
function generateCsrfToken()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * @param string $token
 * @return bool
 */
function verifyCsrfToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Lấy CSRF token input field
 * @return string HTML input field
 */
function csrfField()
{
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}
