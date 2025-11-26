<?php

namespace Middleware;

/**
 * AuthMiddleware
 * Kiểm tra người dùng đã đăng nhập chưa
 * Dùng cho các trang yêu cầu authentication (profile, checkout, orders...)
 */
class AuthMiddleware
{
    /**
     * Xử lý middleware
     * @return bool True nếu pass, False nếu fail
     */
    public static function handle()
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!isAuthenticated()) {
            // Lưu URL hiện tại để redirect lại sau khi login
            $_SESSION['redirect_after_login'] = currentUrl();

            // Set flash message
            setFlashMessage('warning', 'Vui lòng đăng nhập để tiếp tục!');

            // Redirect về trang login
            redirect('/login');
            exit;
        }

        return true;
    }

    /**
     * Kiểm tra và cho phép tiếp tục
     * @return void
     */
    public static function check()
    {
        self::handle();
    }
}
