<?php
/**
 * Admin Header Component
 * 
 * @param string $pageTitle Page title for browser
 * @param string $headerTitle Display title in header
 */

$headerTitle = $headerTitle ?? 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= config('app.base_url') ?>">
    <title><?= escape($pageTitle ?? 'Admin - Phone Shop') ?></title>
    <link rel="stylesheet" href="<?= url('/resources/css/admin.css') ?>">
</head>

<body>
    <div class="header">
        <h1><?= escape($headerTitle) ?></h1>
        <div class="header-actions">
            <a href="<?= url('/admin/dashboard') ?>">📊 Dashboard</a>
            <a href="<?= url('/admin/products') ?>">📦 Sản phẩm</a>
            <a href="<?= url('/admin/orders') ?>">🛒 Đơn hàng</a>
            <a href="<?= url('/admin/customers') ?>">👥 Khách hàng</a>
            <a href="<?= url('/admin/brands') ?>">🏷️ Thương hiệu</a>
            <a href="<?= url('/') ?>" target="_blank">🏠 Trang chủ</a>
            <a href="<?= url('/admin/logout') ?>">🚪 Đăng xuất</a>
        </div>
    </div>