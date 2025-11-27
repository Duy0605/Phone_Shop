<?php
$pageTitle = 'Tìm kiếm: ' . escape($_GET['q'] ?? '') . ' - Phone Shop';
$pageCSS = ['products'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="products-header">
    <h1>🔍 Kết quả tìm kiếm</h1>
    <p>Từ khóa: "<?= escape($_GET['q'] ?? '') ?>"</p>
</div>

<div class="container">
    <!-- Search Form -->
    <?php include __DIR__ . '/../components/search-form.php'; ?>

    <!-- Search Results -->
    <?php if (!empty($products)): ?>
        <p style="margin-bottom: 1rem; color: #666;">
            Tìm thấy <?= count($products) ?> sản phẩm
        </p>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <?php include __DIR__ . '/../components/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-products">
            <div style="font-size: 5rem;">🔍</div>
            <h2>Không tìm thấy kết quả</h2>
            <p>Không có sản phẩm nào phù hợp với từ khóa "<?= escape($_GET['q'] ?? '') ?>"</p>
            <a href="<?= url('/products') ?>" class="btn btn-primary">Xem tất cả sản phẩm</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>