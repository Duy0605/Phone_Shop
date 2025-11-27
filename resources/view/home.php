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
        <a href="<?= url('/products') ?>" class="btn-primary">Xem sản phẩm</a>
    </div>

    <!-- Brands Section -->
    <?php if (!empty($brands)): ?>
        <div class="section-title">
            <h2>🏷️ Thương hiệu nổi bật</h2>
        </div>
        <div class="brands-slider">
            <?php foreach ($brands as $brand): ?>
                <div class="brand-item">
                    <a href="<?= url('/products/brand/' . escape($brand['slug'])) ?>">
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
                <?php include __DIR__ . '/components/product-card.php'; ?>
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
                <?php include __DIR__ . '/components/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>