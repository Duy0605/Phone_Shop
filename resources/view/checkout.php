<?php
$pageTitle = 'Đặt hàng - Phone Shop';
$pageCSS = ['checkout'];
include __DIR__ . '/layouts/header-component.php';
?>

<div class="container">
    <h1>🛒 Đặt hàng</h1>

    <?php if (empty($cartItems)): ?>
        <div class="empty-checkout">
            <div style="font-size: 5rem;">🛍️</div>
            <h2>Giỏ hàng trống</h2>
            <p>Bạn cần thêm sản phẩm vào giỏ hàng trước khi đặt hàng</p>
            <a href="<?= url('/products') ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <form method="POST" action="<?= url('/checkout') ?>">
            <div class="checkout-container">
                <div class="checkout-form">
                    <h2>📋 Thông tin giao hàng</h2>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger">
                            <?= escape($_SESSION['error_message']) ?>
                            <?php unset($_SESSION['error_message']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="name">Họ và tên người nhận *</label>
                        <input type="text" id="name" name="name"
                            value="<?= escape($_POST['name'] ?? $user['name'] ?? '') ?>" placeholder="Nhập họ tên" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại *</label>
                        <input type="tel" id="phone" name="phone"
                            value="<?= escape($_POST['phone'] ?? $user['phone'] ?? '') ?>" placeholder="0xxxxxxxxx"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ giao hàng *</label>
                        <textarea id="address" name="address" required
                            placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố"><?= escape($_POST['address'] ?? $user['address'] ?? '') ?></textarea>
                    </div>

                    <h2>💳 Phương thức thanh toán</h2>
                    <div class="payment-methods">
                        <div class="payment-option">
                            <input type="radio" id="cod" name="payment_method" value="cod" checked>
                            <label for="cod">
                                💵 Tiền mặt<br>
                                <small>Thanh toán khi nhận hàng</small>
                            </label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="bank" name="payment_method" value="bank">
                            <label for="bank">
                                🏦 Chuyển khoản<br>
                                <small>Chuyển khoản ngân hàng</small>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note">Ghi chú đơn hàng</label>
                        <textarea id="note" name="note" rows="3"
                            placeholder="Ghi chú thêm về đơn hàng (tùy chọn)"><?= escape($_POST['note'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="order-summary">
                    <h2>📦 Đơn hàng của bạn</h2>

                    <div class="order-items">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="order-item">
                                <div class="order-item-image">
                                    <?php if (!empty($item['product_image'])): ?>
                                        <img src="<?= url('/' . escape($item['product_image'])) ?>"
                                            alt="<?= escape($item['product_name']) ?>">
                                    <?php else: ?>
                                        <div class="no-image">📱</div>
                                    <?php endif; ?>
                                </div>
                                <div class="order-item-info">
                                    <div class="order-item-name"><?= escape($item['product_name']) ?></div>
                                    <div class="order-item-quantity">x<?= $item['quantity'] ?></div>
                                </div>
                                <div class="order-item-price">
                                    <?= formatPrice($item['product_price'] * $item['quantity']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="order-summary-totals">
                        <div class="summary-row">
                            <span>Tạm tính:</span>
                            <span><?= formatPrice($total) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Phí vận chuyển:</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="summary-row total">
                            <span>Tổng cộng:</span>
                            <span><?= formatPrice($total) ?></span>
                        </div>
                    </div>

                    <button type="submit" class="btn-place-order">
                        Đặt hàng
                    </button>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/layouts/footer-component.php'; ?>