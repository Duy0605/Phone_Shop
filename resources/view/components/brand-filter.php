<!-- Brand Filter Component -->
<?php if (!empty($brands)): ?>
    <div class="filter-section">
        <h3>Lọc theo thương hiệu:</h3>
        <div class="filter-buttons">
            <a href="<?= url('/products') ?>" class="filter-btn <?= empty($activeBrand) ? 'active' : '' ?>">Tất cả</a>
            <?php foreach ($brands as $brand): ?>
                <a href="<?= url('/products/brand/' . escape($brand['slug'])) ?>"
                    class="filter-btn <?= !empty($activeBrand) && $brand['id'] === $activeBrand['id'] ? 'active' : '' ?>">
                    <?= escape($brand['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>