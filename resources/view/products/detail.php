<?php
$pageTitle = escape($product['name']) . ' - Phone Shop';
$pageCSS = ['products'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="container">
    <div class="product-detail">
        <div class="product-detail-grid">
            <div class="product-detail-image">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?= config('app.base_url') ?>/<?= escape($product['image']) ?>" alt="<?= escape($product['name']) ?>">
                <?php else: ?>
                    <div class="no-image">📱</div>
                <?php endif; ?>
            </div>

            <div class="product-detail-info">
                <span class="product-brand-tag"><?= escape($product['brand_name'] ?? 'Unknown') ?></span>
                <h1><?= escape($product['name']) ?></h1>
                <div class="product-price-tag"><?= formatPrice($product['price']) ?></div>

                <?php if (!empty($product['description'])): ?>
                    <div class="product-description">
                        <h3>Mô tả sản phẩm</h3>
                        <p><?= nl2br(escape($product['description'])) ?></p>
                    </div>
                <?php endif; ?>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Trạng thái</span>
                        <span class="meta-value" style="color: <?= $product['stock'] > 0 ? '#27ae60' : '#e74c3c' ?>">
                            <?= $product['stock'] > 0 ? 'Còn hàng' : 'Hết hàng' ?>
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tồn kho</span>
                        <span class="meta-value"><?= $product['stock'] ?> sản phẩm</span>
                    </div>
                </div>

                <div class="product-actions-detail">
                    <div class="quantity-selector">
                        <button onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                        <button onclick="increaseQuantity()">+</button>
                    </div>
                    <button class="btn btn-cart" onclick="addToCartWithQuantity(<?= $product['id'] ?>)"
                        style="flex: 1; padding: 1rem;">
                        🛒 Thêm vào giỏ hàng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 2rem;">
        <a href="<?= url('/products') ?>" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>
</div>

<script>
    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    function addToCartWithQuantity(productId) {
        const quantity = document.getElementById('quantity').value;
        addToCart(productId, quantity);
    }
</script>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>