<?php
$pageTitle = 'Giỏ hàng - Phone Shop';
$pageCSS = ['cart'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="container">
    <h1>🛒 Giỏ hàng của bạn</h1>

    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <div style="font-size: 5rem;">🛒</div>
            <h2>Giỏ hàng trống</h2>
            <p>Bạn chưa thêm sản phẩm nào vào giỏ hàng</p>
            <a href="<?= config('app.base_url') ?>/products" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item">
                        <div class="item-image">
                            <?php if (!empty($item['product_image'])): ?>
                                <img src="<?= config('app.base_url') ?>/<?= escape($item['product_image']) ?>"
                                    alt="<?= escape($item['product_name']) ?>">
                            <?php else: ?>
                                <div class="no-image">📱</div>
                            <?php endif; ?>
                        </div>
                        <div class="item-info">
                            <h3><?= escape($item['product_name']) ?></h3>
                            <p class="item-brand"><?= escape($item['brand_name'] ?? 'Unknown') ?></p>
                            <p class="item-price"><?= formatPrice($item['product_price']) ?></p>
                        </div>
                        <div class="item-actions">
                            <div class="quantity-controls">
                                <button onclick="updateCart(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)">-</button>
                                <input type="number" value="<?= $item['quantity'] ?>" min="1" readonly>
                                <button onclick="updateCart(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                            </div>
                            <p class="item-total">Tổng: <?= formatPrice($item['product_price'] * $item['quantity']) ?></p>
                            <button class="btn-remove" onclick="removeFromCart(<?= $item['id'] ?>)">🗑️ Xóa</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <h2>Tóm tắt đơn hàng</h2>
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
                <a href="<?= config('app.base_url') ?>/checkout" class="btn btn-checkout">Thanh toán</a>
                <button class="btn btn-secondary" onclick="clearCart()">Xóa giỏ hàng</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>