<?php

namespace Controllers\Admin;

use Models\User;

/**
 * Admin AuthController
 * Xử lý đăng nhập admin
 */
class AuthController
{
    /**
     * Hiển thị form đăng nhập admin
     */
    public function showLogin()
    {
        // Nếu đã đăng nhập với quyền admin, redirect về dashboard
        if (isAdmin()) {
            redirect('/admin/dashboard');
        }

        $pageTitle = 'Đăng nhập Admin';
        require_once __DIR__ . '/../../../../resources/view/admin/login.php';
    }

    /**
     * Xử lý đăng nhập admin
     */
    public function login()
    {
        if (!isMethod('POST')) {
            redirect('/admin/login');
        }

        $email = post('email');
        $password = post('password');

        // Validate
        $errors = [];

        if (!validateEmail($email)) {
            $errors[] = 'Email không hợp lệ';
        }

        if (!validateRequired($password)) {
            $errors[] = 'Vui lòng nhập mật khẩu';
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/admin/login');
        }

        // Xác thực
        $userModel = new User();
        $user = $userModel->authenticate($email, $password);

        if (!$user) {
            setFlashMessage('error', 'Email hoặc mật khẩu không đúng!');
            redirect('/admin/login');
        }

        // Kiểm tra role admin
        if ($user['role'] !== 'admin') {
            setFlashMessage('error', 'Bạn không có quyền truy cập trang quản trị!');
            redirect('/admin/login');
        }

        // Đăng nhập thành công
        login($user);
        setFlashMessage('success', 'Đăng nhập thành công! Chào mừng ' . $user['name']);
        redirect('/admin/dashboard');
    }

    /**
     * Đăng xuất admin
     */
    public function logout()
    {
        logout();
        setFlashMessage('success', 'Đăng xuất thành công!');
        redirect('/admin/login');
    }
}
