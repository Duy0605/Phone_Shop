<!-- Footer -->
<div class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Về Phone Shop</h3>
            <p>Chuyên cung cấp điện thoại chính hãng với giá tốt nhất thị trường.</p>
        </div>
        <div class="footer-section">
            <h3>Liên kết</h3>
            <ul>
                <li><a href="<?= config('app.base_url') ?>/">Trang chủ</a></li>
                <li><a href="<?= config('app.base_url') ?>/products">Sản phẩm</a></li>
                <li><a href="<?= config('app.base_url') ?>/cart">Giỏ hàng</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Tài khoản</h3>
            <ul>
                <?php if (isAuthenticated()): ?>
                    <li><a href="<?= config('app.base_url') ?>/profile">Thông tin cá nhân</a></li>
                    <li><a href="<?= config('app.base_url') ?>/orders">Đơn hàng của tôi</a></li>
                <?php else: ?>
                    <li><a href="<?= config('app.base_url') ?>/login">Đăng nhập</a></li>
                    <li><a href="<?= config('app.base_url') ?>/register">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Liên hệ</h3>
            <p>📧 Email: contact@phoneshop.com</p>
            <p>📞 Hotline: 032 8322623</p>
            <p>📍 Địa chỉ: TP. Hà Nội</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Phone Shop. All rights reserved.</p>
    </div>
</div>

<!-- Main JavaScript -->
<script src="<?= config('app.base_url') ?>/resources/js/main.js"></script>

<!-- Page Specific JS -->
<?php if (isset($pageJS)): ?>
    <?php foreach ((array) $pageJS as $js): ?>
        <script src="<?= config('app.base_url') ?>/resources/js/<?= $js ?>.js"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>