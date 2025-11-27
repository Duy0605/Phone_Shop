<!-- Product Card Component -->
<?php if (!empty($product)): ?>
    <div class="product-card">
        <div class="product-image">
            <?php if (!empty($product['image'])): ?>
                <img src="<?= config('app.base_url') ?>/<?= escape($product['image']) ?>" alt="<?= escape($product['name']) ?>">
            <?php else: ?>
                📱
            <?php endif; ?>
        </div>
        <div class="product-info">
            <div class="product-brand"><?= escape($product['brand_name'] ?? 'Unknown') ?></div>
            <div class="product-name"><?= escape($product['name']) ?></div>
            <div class="product-price"><?= formatPrice($product['price']) ?></div>
            <div class="product-actions">
                <a href="<?= url('/product/' . escape($product['slug'])) ?>" class="btn btn-detail">Chi tiết</a>
                <button class="btn btn-cart" onclick="addToCart(<?= $product['id'] ?>)">
                    Thêm vào giỏ
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>