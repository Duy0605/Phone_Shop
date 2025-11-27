<!-- Search Form Component -->
<form method="GET" action="<?= config('app.base_url') ?>/products/search" class="search-form">
    <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." value="<?= escape($_GET['q'] ?? '') ?>">
    <button type="submit">🔍 Tìm kiếm</button>
</form>