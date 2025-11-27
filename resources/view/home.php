<?php
$pageTitle = 'Phone Shop - Trang chủ';
$pageCSS = ['home'];
include __DIR__ . '/layouts/header-component.php';
?>

<div class="container">
    <!-- Hero Banner -->
    <div class="hero">
        <h1>Chào mừng đến với Phone Shop</h1>
        <p>Điện thoại chính hãng - Giá tốt nhất thị trường</p>
        <a href="<?= config('app.base_url') ?>/products" class="btn-primary">Xem sản phẩm</a>
    </div>

    <!-- Brands Section -->
    <?php if (!empty($brands)): ?>
        <div class="section-title">
            <h2>🏷️ Thương hiệu nổi bật</h2>
        </div>
        <div class="brands-slider">
            <?php foreach ($brands as $brand): ?>
                <div class="brand-item">
                    <a href="<?= config('app.base_url') ?>/products/brand/<?= escape($brand['slug']) ?>">
                        <?= escape($brand['name']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Featured Products -->
    <?php if (!empty($featuredProducts)): ?>
        <div class="section-title">
            <h2>⭐ Sản phẩm nổi bật</h2>
            <p>Những sản phẩm được ưa chuộng nhất</p>
        </div>
        <div class="products-grid">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= config('app.base_url') ?>/<?= escape($product['image']) ?>"
                                alt="<?= escape($product['name']) ?>">
                        <?php else: ?>
                            📱
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <div class="product-brand"><?= escape($product['brand_name'] ?? 'Unknown') ?></div>
                        <div class="product-name"><?= escape($product['name']) ?></div>
                        <div class="product-price"><?= formatPrice($product['price']) ?></div>
                        <div class="product-actions">
                            <a href="<?= config('app.base_url') ?>/product/<?= escape($product['slug']) ?>"
                                class="btn btn-detail">Chi tiết</a>
                            <button class="btn btn-cart" onclick="addToCart(<?= $product['id'] ?>)">
                                Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Latest Products -->
    <?php if (!empty($latestProducts)): ?>
        <div class="section-title">
            <h2>🆕 Sản phẩm mới nhất</h2>
            <p>Cập nhật liên tục các mẫu điện thoại mới</p>
        </div>
        <div class="products-grid">
            <?php foreach ($latestProducts as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= config('app.base_url') ?>/<?= escape($product['image']) ?>"
                                alt="<?= escape($product['name']) ?>">
                        <?php else: ?>
                            📱
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <div class="product-brand"><?= escape($product['brand_name'] ?? 'Unknown') ?></div>
                        <div class="product-name"><?= escape($product['name']) ?></div>
                        <div class="product-price"><?= formatPrice($product['price']) ?></div>
                        <div class="product-actions">
                            <a href="<?= config('app.base_url') ?>/product/<?= escape($product['slug']) ?>"
                                class="btn btn-detail">Chi tiết</a>
                            <button class="btn btn-cart" onclick="addToCart(<?= $product['id'] ?>)">
                                Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div style="font-size: 5rem;">📱</div>
            <h3>Chưa có sản phẩm nào</h3>
            <p>Hệ thống đang cập nhật sản phẩm mới</p>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/layouts/footer-component.php'; ?>