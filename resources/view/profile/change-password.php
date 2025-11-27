<?php
$pageTitle = 'Đổi mật khẩu - Phone Shop';
$pageCSS = ['profile'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="container">
    <h1>🔒 Đổi mật khẩu</h1>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= escape($_SESSION['success_message']) ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?= escape($_SESSION['error_message']) ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <div class="profile-container">
        <div class="profile-content">
            <form method="POST" action="<?= config('app.base_url') ?>/profile/change-password">
                <div class="form-group">
                    <label for="current_password">Mật khẩu hiện tại *</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">Mật khẩu mới *</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu mới *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="password-requirements">
                    <h4>Yêu cầu mật khẩu:</h4>
                    <ul>
                        <li>Tối thiểu 6 ký tự</li>
                        <li>Nên bao gồm chữ hoa, chữ thường và số</li>
                        <li>Không nên dùng thông tin cá nhân dễ đoán</li>
                    </ul>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                    <a href="<?= config('app.base_url') ?>/profile" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>