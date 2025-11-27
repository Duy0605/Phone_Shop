<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= config('app.base_url') ?>">
    <title><?= $pageTitle ?? 'Quản lý sản phẩm' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.5rem;
        }

        .nav-menu {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 0;
        }

        .nav-menu a {
            color: #667eea;
            text-decoration: none;
            margin-right: 2rem;
            font-weight: 500;
        }

        .nav-menu a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-header h2 {
            color: #333;
            font-size: 1.5rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filters input,
        .filters select {
            padding: 0.6rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .filters input {
            flex: 1;
            min-width: 200px;
        }

        .filters select {
            min-width: 150px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }

        table td {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        table tr:hover {
            background: #f8f9fa;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .product-name {
            font-weight: 500;
            color: #333;
        }

        .product-brand {
            color: #666;
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        .stock-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .stock-in {
            background: #d1e7dd;
            color: #0f5132;
        }

        .stock-low {
            background: #fff3cd;
            color: #856404;
        }

        .stock-out {
            background: #f8d7da;
            color: #842029;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: #667eea;
        }

        .pagination a:hover {
            background: #f0f0f0;
        }

        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .alert-error {
            background: #f8d7da;
            color: #842029;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .no-data {
            text-align: center;
            padding: 3rem;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📱 Quản lý sản phẩm - Phone Shop</h1>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span>👤 <?= escape(getUserName() ?? 'Admin') ?></span>
            <a href="<?= config('app.base_url') ?>/admin/logout" style="color: white; text-decoration: none;">Đăng
                xuất</a>
        </div>
    </div>

    <div class="nav-menu">
        <a href="<?= config('app.base_url') ?>/admin/dashboard">Dashboard</a>
        <a href="<?= config('app.base_url') ?>/admin/products" style="color: #764ba2; font-weight: 600;">Sản phẩm</a>
        <a href="<?= config('app.base_url') ?>/admin/brands">Thương hiệu</a>
        <a href="<?= config('app.base_url') ?>/admin/orders">Đơn hàng</a>
        <a href="<?= config('app.base_url') ?>/admin/customers">Khách hàng</a>
    </div>

    <div class="container">
        <?php
        $flash = getFlashMessage();
        if ($flash):
            ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <div class="section">
            <div class="section-header">
                <h2>📦 Danh sách sản phẩm</h2>
                <a href="<?= config('app.base_url') ?>/admin/products/create" class="btn btn-success">
                    ➕ Thêm sản phẩm mới
                </a>
            </div>

            <form method="GET" action="<?= config('app.base_url') ?>/admin/products" class="filters">
                <input type="text" name="search" placeholder="🔍 Tìm kiếm sản phẩm..."
                    value="<?= escape(get('search', '')) ?>">

                <select name="brand" onchange="this.form.submit()">
                    <option value="">-- Tất cả thương hiệu --</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>" <?= get('brand') == $brand['id'] ? 'selected' : '' ?>>
                            <?= escape($brand['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn btn-primary">Lọc</button>

                <?php if (get('search') || get('brand')): ?>
                    <a href="<?= config('app.base_url') ?>/admin/products" class="btn"
                        style="background: #6c757d; color: white;">
                        Xóa bộ lọc
                    </a>
                <?php endif; ?>
            </form>

            <?php if (!empty($products)): ?>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 80px;">Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Ngày tạo</th>
                            <th style="width: 200px; text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?php if ($product['image']): ?>
                                        <img src="<?= config('app.base_url') ?>/<?= escape($product['image']) ?>"
                                            alt="<?= escape($product['name']) ?>" class="product-img">
                                    <?php else: ?>
                                        <div class="product-img"
                                            style="background: #eee; display: flex; align-items: center; justify-content: center;">
                                            📱
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="product-name"><?= escape($product['name']) ?></div>
                                    <div class="product-brand">
                                        🏷️ <?= escape($product['brand_name'] ?? 'Chưa rõ') ?>
                                    </div>
                                </td>
                                <td style="font-weight: 600; color: #667eea;">
                                    <?= formatPrice($product['price']) ?>
                                </td>
                                <td>
                                    <?php
                                    $stock = (int) $product['stock'];
                                    if ($stock === 0) {
                                        $stockClass = 'stock-out';
                                        $stockText = 'Hết hàng';
                                    } elseif ($stock < 10) {
                                        $stockClass = 'stock-low';
                                        $stockText = $stock . ' sản phẩm';
                                    } else {
                                        $stockClass = 'stock-in';
                                        $stockText = $stock . ' sản phẩm';
                                    }
                                    ?>
                                    <span class="stock-badge <?= $stockClass ?>">
                                        <?= $stockText ?>
                                    </span>
                                </td>
                                <td style="color: #666; font-size: 0.9rem;">
                                    <?= formatDateTime($product['created_at']) ?>
                                </td>
                                <td>
                                    <div class="actions" style="justify-content: center;">
                                        <a href="<?= config('app.base_url') ?>/admin/products/edit/<?= $product['id'] ?>"
                                            class="btn btn-primary btn-sm">
                                            ✏️ Sửa
                                        </a>
                                        <form method="POST"
                                            action="<?= config('app.base_url') ?>/admin/products/delete/<?= $product['id'] ?>"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                                            style="display: inline;">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                🗑️ Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($pagination['total_pages'] > 1): ?>
                    <div class="pagination">
                        <?php if ($pagination['current_page'] > 1): ?>
                            <a
                                href="?page=<?= $pagination['current_page'] - 1 ?><?= get('search') ? '&search=' . urlencode(get('search')) : '' ?><?= get('brand') ? '&brand=' . get('brand') : '' ?>">
                                ‹ Trước
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                            <?php if ($i == $pagination['current_page']): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a
                                    href="?page=<?= $i ?><?= get('search') ? '&search=' . urlencode(get('search')) : '' ?><?= get('brand') ? '&brand=' . get('brand') : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <a
                                href="?page=<?= $pagination['current_page'] + 1 ?><?= get('search') ? '&search=' . urlencode(get('search')) : '' ?><?= get('brand') ? '&brand=' . get('brand') : '' ?>">
                                Sau ›
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="no-data">
                    <p style="font-size: 3rem; margin-bottom: 1rem;">📦</p>
                    <p style="font-size: 1.2rem;">Chưa có sản phẩm nào</p>
                    <?php if (get('search') || get('brand')): ?>
                        <p style="margin-top: 0.5rem;">
                            <a href="<?= config('app.base_url') ?>/admin/products">Xem tất cả sản phẩm</a>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>