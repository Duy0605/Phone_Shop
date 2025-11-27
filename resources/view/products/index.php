<?php
$pageTitle = 'Sản phẩm - Phone Shop';
$pageCSS = ['products'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="products-header">
    <h1>📱 Danh sách sản phẩm</h1>
    <p>Khám phá các sản phẩm điện thoại chất lượng</p>
</div>

<div class="container">
    <!-- Search Form -->
    <form method="GET" action="<?= config('app.base_url') ?>/products/search" class="search-form">
        <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." value="<?= escape($_GET['q'] ?? '') ?>">
        <button type="submit">🔍 Tìm kiếm</button>
    </form>

    <!-- Brand Filter -->
    <?php if (!empty($brands)): ?>
        <div class="filter-section">
            <h3>Lọc theo thương hiệu:</h3>
            <div class="filter-buttons">
                <a href="<?= config('app.base_url') ?>/products" class="filter-btn">Tất cả</a>
                <?php foreach ($brands as $brand): ?>
                    <a href="<?= config('app.base_url') ?>/products/brand/<?= escape($brand['slug']) ?>" class="filter-btn">
                        <?= escape($brand['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Products Grid -->
    <?php if (!empty($products)): ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
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
        <div class="empty-products">
            <div style="font-size: 5rem;">📱</div>
            <h2>Không tìm thấy sản phẩm</h2>
            <p>Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm</p>
            <a href="<?= config('app.base_url') ?>/products" class="btn btn-primary">Xem tất cả sản phẩm</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>