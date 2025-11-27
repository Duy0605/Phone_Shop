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
    <?php include __DIR__ . '/../components/search-form.php'; ?>

    <!-- Brand Filter -->
    <?php include __DIR__ . '/../components/brand-filter.php'; ?>

    <!-- Products Grid -->
    <?php if (!empty($products)): ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <?php include __DIR__ . '/../components/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-products">
            <div style="font-size: 5rem;">📱</div>
            <h2>Không tìm thấy sản phẩm</h2>
            <p>Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm</p>
            <a href="<?= url('/products') ?>" class="btn btn-primary">Xem tất cả sản phẩm</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>