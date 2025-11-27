<?php
$pageTitle = 'Giỏ hàng - Phone Shop';
$pageCSS = ['cart'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="container">
    <h1>🛒 Giỏ hàng của bạn</h1>

    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <div style="font-size: 5rem;">🛍️</div>
            <h2>Giỏ hàng trống</h2>
            <p>Bạn chưa thêm sản phẩm nào vào giỏ hàng</p>
            <a href="<?= url('/products') ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <div class="cart-items">
                <div class="cart-header">
                    <label class="select-all">
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                        <span>Chọn tất cả</span>
                    </label>
                    <button class="btn-clear-cart" onclick="clearCart()">Xóa giỏ hàng</button>
                </div>
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item">
                        <div class="item-checkbox">
                            <input type="checkbox" class="item-select" data-id="<?= $item['id'] ?>"
                                data-price="<?= $item['product_price'] ?>" data-quantity="<?= $item['quantity'] ?>"
                                onchange="updateTotal()">
                        </div>
                        <div class="item-image">
                            <?php if (!empty($item['product_image'])): ?>
                                <img src="<?= url('/' . escape($item['product_image'])) ?>"
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
                                <input type="number" value="<?= $item['quantity'] ?>" min="0" readonly>
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
                    <span id="subtotal"><?= formatPrice(0) ?></span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <div class="summary-row total">
                    <span>Tổng cộng:</span>
                    <span id="totalAmount"><?= formatPrice(0) ?></span>
                </div>
                <div class="selected-count">
                    <small>Đã chọn: <span id="selectedCount">0</span> sản phẩm</small>
                </div>
                <button type="button" class="btn btn-checkout" onclick="showCheckoutModal()">Đặt hàng</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Đặt hàng -->
<div id="checkoutModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeCheckoutModal()">&times;</span>
        <h2>📋 Thông tin đặt hàng</h2>

        <form method="POST" action="<?= url('/checkout') ?>" id="checkoutForm">
            <?= csrfField() ?>

            <!-- Hidden input chứa danh sách item IDs được chọn -->
            <input type="hidden" id="selectedItemIds" name="selected_items" value="">

            <div class="form-group">
                <label for="customer_name">Họ và tên người nhận *</label>
                <input type="text" id="customer_name" name="customer_name" value="<?= escape($user['name'] ?? '') ?>"
                    placeholder="Nhập họ tên" required>
            </div>

            <div class="form-group">
                <label for="customer_phone">Số điện thoại *</label>
                <input type="tel" id="customer_phone" name="customer_phone" value="<?= escape($user['phone'] ?? '') ?>"
                    placeholder="0xxxxxxxxx" required>
            </div>

            <div class="form-group">
                <label for="customer_address">Địa chỉ giao hàng *</label>
                <textarea id="customer_address" name="customer_address" required
                    placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố"><?= escape($user['address'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>💳 Phương thức thanh toán</label>
                <div class="payment-methods">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <span>💵 Tiền mặt (COD)</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="bank">
                        <span>🏦 Chuyển khoản</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Ghi chú đơn hàng</label>
                <textarea id="notes" name="notes" rows="3" placeholder="Ghi chú thêm về đơn hàng (tùy chọn)"></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeCheckoutModal()">Hủy</button>
                <button type="submit" class="btn btn-primary">Xác nhận đặt hàng</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>