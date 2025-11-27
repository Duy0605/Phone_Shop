<?php

namespace Controllers;

use Models\User;

/**
 * AuthController
 * Xử lý đăng nhập, đăng ký, profile
 */
class AuthController
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLogin()
    {
        // Nếu đã đăng nhập, redirect về home
        if (isAuthenticated()) {
            redirect('/');
        }

        $pageTitle = 'Đăng nhập';
        require_once __DIR__ . '/../../../resources/view/auth/login.php';
    }

    /**
     * Xử lý đăng nhập
     */
    public function login()
    {
        if (!isMethod('POST')) {
            redirect('/login');
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
            redirect('/login');
        }

        // Xác thực
        $userModel = new User();
        $user = $userModel->authenticate($email, $password);

        if (!$user) {
            setFlashMessage('error', 'Email hoặc mật khẩu không đúng!');
            redirect('/login');
        }

        // Đăng nhập thành công
        login($user);
        setFlashMessage('success', 'Đăng nhập thành công! Chào mừng ' . $user['name']);

        // Redirect theo role
        if ($user['role'] === 'admin') {
            redirect('/admin/dashboard');
        } else {
            redirect('/');
        }
    }

    /**
     * Hiển thị form đăng ký
     */
    public function showRegister()
    {
        // Nếu đã đăng nhập, redirect về home
        if (isAuthenticated()) {
            redirect('/');
        }

        $pageTitle = 'Đăng ký';
        require_once __DIR__ . '/../../../resources/view/auth/register.php';
    }

    /**
     * Xử lý đăng ký
     */
    public function register()
    {
        if (!isMethod('POST')) {
            redirect('/register');
        }

        $name = trim(post('name'));
        $email = trim(post('email'));
        $phone = trim(post('phone'));
        $password = post('password');
        $confirmPassword = post('confirm_password');

        // Validate
        $errors = [];

        if (!validateRequired($name)) {
            $errors[] = 'Vui lòng nhập họ tên';
        }

        if (!validateEmail($email)) {
            $errors[] = 'Email không hợp lệ';
        }

        if (!validatePhone($phone)) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }

        $passwordValidation = validatePassword($password);
        if (!$passwordValidation['valid']) {
            $errors[] = $passwordValidation['message'];
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Mật khẩu xác nhận không khớp';
        }

        // Kiểm tra email/phone đã tồn tại
        $userModel = new User();

        if ($userModel->emailExists($email)) {
            $errors[] = 'Email đã được sử dụng';
        }

        if ($userModel->phoneExists($phone)) {
            $errors[] = 'Số điện thoại đã được sử dụng';
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/register');
        }

        // Đăng ký
        $userId = $userModel->register([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password
        ]);

        if ($userId) {
            setFlashMessage('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
            redirect('/login');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
            redirect('/register');
        }
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        logout();
        setFlashMessage('success', 'Đăng xuất thành công!');
        redirect('/');
    }

    /**
     * Hiển thị trang profile
     */
    public function profile()
    {
        requireAuth();

        $userModel = new User();
        $user = $userModel->find(getUserId());

        $pageTitle = 'Thông tin cá nhân';
        require_once __DIR__ . '/../../../resources/view/profile/index.php';
    }

    /**
     * Cập nhật profile
     */
    public function updateProfile()
    {
        requireAuth();

        if (!isMethod('POST')) {
            redirect('/profile');
        }

        $name = post('name');
        $phone = post('phone');

        // Validate
        $errors = [];

        if (!validateRequired($name)) {
            $errors[] = 'Vui lòng nhập họ tên';
        }

        if (!validatePhone($phone)) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }

        $userModel = new User();

        // Kiểm tra phone đã tồn tại (trừ user hiện tại)
        if ($userModel->phoneExists($phone, getUserId())) {
            $errors[] = 'Số điện thoại đã được sử dụng';
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/profile');
        }

        // Cập nhật
        $updated = $userModel->updateUser(getUserId(), [
            'name' => $name,
            'phone' => $phone
        ]);

        if ($updated) {
            // Cập nhật lại session
            $_SESSION['user_name'] = $name;
            setFlashMessage('success', 'Cập nhật thông tin thành công!');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }

        redirect('/profile');
    }

    /**
     * Hiển thị form đổi mật khẩu
     */
    public function showChangePassword()
    {
        requireAuth();

        $pageTitle = 'Đổi mật khẩu';
        require_once __DIR__ . '/../../../resources/view/profile/change-password.php';
    }

    /**
     * Xử lý đổi mật khẩu
     */
    public function changePassword()
    {
        requireAuth();

        if (!isMethod('POST')) {
            redirect('/profile/change-password');
        }

        $currentPassword = post('current_password');
        $newPassword = post('new_password');
        $confirmPassword = post('confirm_password');

        // Validate
        $errors = [];

        if (!validateRequired($currentPassword)) {
            $errors[] = 'Vui lòng nhập mật khẩu hiện tại';
        }

        $passwordValidation = validatePassword($newPassword);
        if (!$passwordValidation['valid']) {
            $errors[] = $passwordValidation['message'];
        }

        if ($newPassword !== $confirmPassword) {
            $errors[] = 'Mật khẩu mới xác nhận không khớp';
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/profile/change-password');
        }

        // Kiểm tra mật khẩu hiện tại
        $userModel = new User();
        $user = $userModel->find(getUserId());

        if (!verifyPassword($currentPassword, $user['password'])) {
            setFlashMessage('error', 'Mật khẩu hiện tại không đúng!');
            redirect('/profile/change-password');
        }

        // Đổi mật khẩu
        $changed = $userModel->changePassword(getUserId(), $newPassword);

        if ($changed) {
            setFlashMessage('success', 'Đổi mật khẩu thành công!');
            redirect('/profile');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
            redirect('/profile/change-password');
        }
    }
}
