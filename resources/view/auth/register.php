<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= config('app.base_url') ?>">
    <title>Đăng ký - Phone Shop</title>
    <link rel="stylesheet" href="<?= config('app.base_url') ?>/resources/css/main.css">
    <link rel="stylesheet" href="<?= config('app.base_url') ?>/resources/css/auth.css">
</head>

<body class="auth-page">
    <div class="auth-container register-container">
        <div class="auth-header">
            <div class="auth-icon">📱</div>
            <h1>Đăng ký</h1>
            <p>Tạo tài khoản mới tại Phone Shop</p>
        </div>

        <div class="auth-body">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?= escape($_SESSION['error_message']) ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= config('app.base_url') ?>/register">
                <div class="form-group">
                    <label for="name">Họ và tên *</label>
                    <input type="text" id="name" name="name" value="<?= escape($_POST['name'] ?? '') ?>"
                        placeholder="Nhập họ tên của bạn" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?= escape($_POST['email'] ?? '') ?>"
                        placeholder="Nhập email của bạn" required>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại *</label>
                    <input type="tel" id="phone" name="phone" value="<?= escape($_POST['phone'] ?? '') ?>"
                        placeholder="0xxxxxxxxx" required>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu *</label>
                    <input type="password" id="password" name="password" placeholder="Tối thiểu 6 ký tự" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu *</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu"
                        required>
                </div>

                <button type="submit" class="btn-submit">Đăng ký</button>
            </form>
        </div>

        <div class="auth-links">
            <p>Đã có tài khoản? <a href="<?= config('app.base_url') ?>/login">Đăng nhập</a></p>
            <p><a href="<?= config('app.base_url') ?>/">← Quay lại trang chủ</a></p>
        </div>
    </div>

    <script src="<?= config('app.base_url') ?>/resources/js/main.js"></script>
</body>

</html>