<?php

namespace Middleware;

/**
 * AdminMiddleware
 * Kiểm tra người dùng có quyền admin không
 * Dùng cho tất cả các trang quản trị
 */
class AdminMiddleware
{
    /**
     * Xử lý middleware
     * @return bool True nếu pass, False nếu fail
     */
    public static function handle()
    {
        // Kiểm tra đã đăng nhập chưa
        if (!isAuthenticated()) {
            setFlashMessage('warning', 'Vui lòng đăng nhập để truy cập trang quản trị!');
            redirect('/admin/login');
            exit;
        }

        // Kiểm tra có quyền admin không
        if (!isAdmin()) {
            setFlashMessage('error', 'Bạn không có quyền truy cập trang này!');
            redirect('/');
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
