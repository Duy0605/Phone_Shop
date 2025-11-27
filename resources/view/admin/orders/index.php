<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= config('app.base_url') ?>">
    <title><?= $pageTitle ?? 'Quản lý đơn hàng' ?></title>
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

        .btn {
            padding: 0.6rem 1.5rem;
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

        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
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

        .badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-processing {
            background: #cfe2ff;
            color: #084298;
        }

        .badge-shipping {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-delivered {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-cancelled {
            background: #f8d7da;
            color: #842029;
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

        .no-data {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .stats-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 6px;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 6px;
        }

        .stat-item .number {
            font-size: 1.2rem;
            font-weight: 600;
            color: #667eea;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📦 Quản lý đơn hàng - Phone Shop</h1>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span>👤 <?= escape(getUserName() ?? 'Admin') ?></span>
            <a href="<?= config('app.base_url') ?>/admin/logout" style="color: white; text-decoration: none;">Đăng
                xuất</a>
        </div>
    </div>

    <div class="nav-menu">
        <a href="<?= config('app.base_url') ?>/admin/dashboard">Dashboard</a>
        <a href="<?= config('app.base_url') ?>/admin/products">Sản phẩm</a>
        <a href="<?= config('app.base_url') ?>/admin/brands">Thương hiệu</a>
        <a href="<?= config('app.base_url') ?>/admin/orders" style="color: #764ba2; font-weight: 600;">Đơn hàng</a>
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
                <div>
                    <h2>📋 Danh sách đơn hàng</h2>
                    <p style="color: #666; margin-top: 0.5rem;">
                        Tổng: <strong><?= $pagination['total'] ?></strong> đơn hàng
                    </p>
                </div>
            </div>

            <div class="stats-bar">
                <div class="stat-item">
                    <span class="badge badge-pending">⏳</span>
                    <span class="number">
                        <?php
                        $pendingCount = 0;
                        foreach ($orders as $o) {
                            if ($o['status'] === 'pending')
                                $pendingCount++;
                        }
                        echo $pendingCount;
                        ?>
                    </span>
                    <span>Chờ xử lý</span>
                </div>
                <div class="stat-item">
                    <span class="badge badge-processing">⚙️</span>
                    <span class="number">
                        <?php
                        $processingCount = 0;
                        foreach ($orders as $o) {
                            if ($o['status'] === 'processing')
                                $processingCount++;
                        }
                        echo $processingCount;
                        ?>
                    </span>
                    <span>Đang xử lý</span>
                </div>
                <div class="stat-item">
                    <span class="badge badge-shipping">🚚</span>
                    <span class="number">
                        <?php
                        $shippingCount = 0;
                        foreach ($orders as $o) {
                            if ($o['status'] === 'shipping')
                                $shippingCount++;
                        }
                        echo $shippingCount;
                        ?>
                    </span>
                    <span>Đang giao</span>
                </div>
                <div class="stat-item">
                    <span class="badge badge-delivered">✅</span>
                    <span class="number">
                        <?php
                        $deliveredCount = 0;
                        foreach ($orders as $o) {
                            if ($o['status'] === 'delivered')
                                $deliveredCount++;
                        }
                        echo $deliveredCount;
                        ?>
                    </span>
                    <span>Đã giao</span>
                </div>
            </div>

            <form method="GET" action="<?= config('app.base_url') ?>/admin/orders" class="filters">
                <input type="text" name="search" placeholder="🔍 Tìm theo tên, SĐT khách hàng..."
                    value="<?= escape(get('search', '')) ?>">

                <select name="status" onchange="this.form.submit()">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="pending" <?= get('status') === 'pending' ? 'selected' : '' ?>>⏳ Chờ xử lý</option>
                    <option value="processing" <?= get('status') === 'processing' ? 'selected' : '' ?>>⚙️ Đang xử lý
                    </option>
                    <option value="shipping" <?= get('status') === 'shipping' ? 'selected' : '' ?>>🚚 Đang giao</option>
                    <option value="delivered" <?= get('status') === 'delivered' ? 'selected' : '' ?>>✅ Đã giao</option>
                    <option value="cancelled" <?= get('status') === 'cancelled' ? 'selected' : '' ?>>❌ Đã hủy</option>
                </select>

                <button type="submit" class="btn btn-primary">Lọc</button>

                <?php if (get('search') || get('status')): ?>
                    <a href="<?= config('app.base_url') ?>/admin/orders" class="btn"
                        style="background: #6c757d; color: white;">
                        Xóa bộ lọc
                    </a>
                <?php endif; ?>
            </form>

            <?php if (!empty($orders)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th style="width: 120px; text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td style="font-weight: 600; color: #667eea;">
                                    #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td>
                                    <div style="font-weight: 500;"><?= escape($order['customer_name']) ?></div>
                                    <?php if (!empty($order['user_email'])): ?>
                                        <div style="font-size: 0.85rem; color: #666;">
                                            📧 <?= escape($order['user_email']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="color: #666;">
                                    📱 <?= escape($order['customer_phone']) ?>
                                </td>
                                <td style="font-weight: 600; color: #667eea;">
                                    <?= formatPrice($order['total_amount']) ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $order['status'] ?>">
                                        <?php
                                        $icons = [
                                            'pending' => '⏳',
                                            'processing' => '⚙️',
                                            'shipping' => '🚚',
                                            'delivered' => '✅',
                                            'cancelled' => '❌'
                                        ];
                                        echo ($icons[$order['status']] ?? '') . ' ' . ($statusMap[$order['status']] ?? $order['status']);
                                        ?>
                                    </span>
                                </td>
                                <td style="color: #666; font-size: 0.9rem;">
                                    <?= formatDateTime($order['created_at']) ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?= config('app.base_url') ?>/admin/orders/<?= $order['id'] ?>"
                                        class="btn btn-primary btn-sm">
                                        👁️ Xem
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($pagination['total_pages'] > 1): ?>
                    <div class="pagination">
                        <?php if ($pagination['current_page'] > 1): ?>
                            <a
                                href="?page=<?= $pagination['current_page'] - 1 ?><?= get('search') ? '&search=' . urlencode(get('search')) : '' ?><?= get('status') ? '&status=' . get('status') : '' ?>">
                                ‹ Trước
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                            <?php if ($i == $pagination['current_page']): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a
                                    href="?page=<?= $i ?><?= get('search') ? '&search=' . urlencode(get('search')) : '' ?><?= get('status') ? '&status=' . get('status') : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <a
                                href="?page=<?= $pagination['current_page'] + 1 ?><?= get('search') ? '&search=' . urlencode(get('search')) : '' ?><?= get('status') ? '&status=' . get('status') : '' ?>">
                                Sau ›
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="no-data">
                    <p style="font-size: 3rem; margin-bottom: 1rem;">📦</p>
                    <p style="font-size: 1.2rem;">Chưa có đơn hàng nào</p>
                    <?php if (get('search') || get('status')): ?>
                        <p style="margin-top: 0.5rem;">
                            <a href="<?= config('app.base_url') ?>/admin/orders">Xem tất cả đơn hàng</a>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>