<?php
$pageTitle = 'Thông tin cá nhân - Phone Shop';
$pageCSS = ['profile'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="container">
    <h1>👤 Thông tin cá nhân</h1>

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
        <div class="profile-sidebar">
            <div class="profile-avatar">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </div>
            <h2><?= escape($user['name']) ?></h2>
            <p><?= escape($user['email']) ?></p>
            <a href="<?= config('app.base_url') ?>/profile/change-password" class="btn btn-secondary">Đổi mật khẩu</a>
        </div>

        <div class="profile-content">
            <h2>Chỉnh sửa thông tin</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Họ và tên *</label>
                    <input type="text" id="name" name="name" value="<?= escape($user['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?= escape($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" value="<?= escape($user['phone'] ?? '') ?>"
                        placeholder="0xxxxxxxxx">
                </div>

                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <textarea id="address" name="address" rows="3"><?= escape($user['address'] ?? '') ?></textarea>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Ngày tạo:</span>
                        <span class="info-value"><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Cập nhật:</span>
                        <span class="info-value"><?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="<?= url('/') ?>" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>