<!-- Header Component -->
<!DOCTYPE html>
<html lang="vi" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= config('app.base_url') ?>">
    <title><?= $pageTitle ?? 'Phone Shop' ?></title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= config('app.base_url') ?>/resources/css/main.css">

    <!-- Page Specific CSS -->
    <?php if (isset($pageCSS)): ?>
        <?php foreach ((array) $pageCSS as $css): ?>
            <link rel="stylesheet" href="<?= config('app.base_url') ?>/resources/css/<?= $css ?>.css">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <!-- Sticky Header -->
    <div class="header">
        <div class="header-top">
            <a href="<?= url('/') ?>" class="logo">📱 Phone Shop</a>
            <nav class="nav-menu">
                <a href="<?= url('/') ?>">Trang chủ</a>
                <a href="<?= url('/products') ?>">Sản phẩm</a>
                <a href="<?= url('/cart') ?>">🛒 Giỏ hàng</a>
                <?php if (isAuthenticated()): ?>
                    <a href="<?= url('/profile') ?>">👤 <?= escape(getUserName()) ?></a>
                    <a href="<?= url('/orders') ?>">Đơn hàng</a>
                    <a href="<?= url('/logout') ?>">Đăng xuất</a>
                <?php else: ?>
                    <a href="<?= url('/login') ?>">Đăng nhập</a>
                    <a href="<?= url('/register') ?>">Đăng ký</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>