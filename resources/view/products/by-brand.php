<?php
$pageTitle = escape($brand['name']) . ' - Phone Shop';
$pageCSS = ['products'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="products-header">
    <h1>📱 <?= escape($brand['name']) ?></h1>
    <p>Sản phẩm của thương hiệu <?= escape($brand['name']) ?></p>
</div>

<div class="container">
    <!-- Search Form -->
    <?php include __DIR__ . '/../components/search-form.php'; ?>

    <!-- Brand Filter -->
    <?php $activeBrand = $brand;
    include __DIR__ . '/../components/brand-filter.php'; ?>

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
            <h2>Chưa có sản phẩm</h2>
            <p>Thương hiệu <?= escape($brand['name']) ?> chưa có sản phẩm nào</p>
            <a href="<?= url('/products') ?>" class="btn btn-primary">Xem tất cả sản phẩm</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>