<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= config('app.base_url') ?>">
    <title>Đăng nhập - Phone Shop</title>
    <link rel="stylesheet" href="<?= config('app.base_url') ?>/resources/css/main.css">
    <link rel="stylesheet" href="<?= config('app.base_url') ?>/resources/css/auth.css">
</head>

<body class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon">📱</div>
            <h1>Đăng nhập</h1>
            <p>Chào mừng trở lại Phone Shop</p>
        </div>

        <div class="auth-body">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?= escape($_SESSION['error_message']) ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?= escape($_SESSION['success_message']) ?>
                    <?php unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= config('app.base_url') ?>/login">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?= escape($_POST['email'] ?? '') ?>"
                        placeholder="Nhập email của bạn" required>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu *</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>

                <button type="submit" class="btn-submit">Đăng nhập</button>
            </form>
        </div>

        <div class="auth-links">
            <p>Chưa có tài khoản? <a href="<?= config('app.base_url') ?>/register">Đăng ký ngay</a></p>
            <p><a href="<?= config('app.base_url') ?>/">← Quay lại trang chủ</a></p>
        </div>
    </div>

    <script src="<?= config('app.base_url') ?>/resources/js/main.js"></script>
</body>

</html>