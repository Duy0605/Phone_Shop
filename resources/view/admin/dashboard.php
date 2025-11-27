<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= config('app.base_url') ?>">
    <title><?= $pageTitle ?? 'Dashboard - Admin' ?></title>
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

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-card .icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            margin: 0.5rem 0;
        }

        .stat-card .label {
            color: #666;
            font-size: 0.9rem;
        }

        .section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .section h2 {
            margin-bottom: 1.5rem;
            color: #333;
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

        .badge-delivered {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-cancelled {
            background: #f8d7da;
            color: #842029;
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
    </style>
</head>

<body>
    <div class="header">
        <h1>🎛️ Admin Dashboard - Phone Shop</h1>
        <div class="user-info">
            <span>👤 <?= escape(getUserName() ?? 'Admin') ?></span>
            <a href="<?= config('app.base_url') ?>/admin/logout" style="color: white; text-decoration: none;">Đăng
                xuất</a>
        </div>
    </div>

    <div class="nav-menu">
        <a href="<?= config('app.base_url') ?>/admin/dashboard">Dashboard</a>
        <a href="<?= config('app.base_url') ?>/admin/products">Sản phẩm</a>
        <a href="<?= config('app.base_url') ?>/admin/brands">Thương hiệu</a>
        <a href="<?= config('app.base_url') ?>/admin/orders">Đơn hàng</a>
        <a href="<?= config('app.base_url') ?>/admin/customers">Khách hàng</a>
    </div>

    <div class="container">
        <?php
        $flash = getFlashMessage();
        if ($flash):
            ?>
            <div style="padding: 1rem; background: <?= $flash['type'] === 'error' ? '#fee' : '#efe' ?>; 
                        color: <?= $flash['type'] === 'error' ? '#c33' : '#3c3' ?>; 
                        border-radius: 8px; margin-bottom: 1rem;">
                <?= escape($flash['message']) ?>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">📦</div>
                <div class="value"><?= $stats['total_orders'] ?? 0 ?></div>
                <div class="label">Tổng đơn hàng</div>
            </div>

            <div class="stat-card">
                <div class="icon">⏳</div>
                <div class="value"><?= $stats['pending_orders'] ?? 0 ?></div>
                <div class="label">Đơn chờ xử lý</div>
            </div>

            <div class="stat-card">
                <div class="icon">👥</div>
                <div class="value"><?= $stats['total_customers'] ?? 0 ?></div>
                <div class="label">Khách hàng</div>
            </div>

            <div class="stat-card">
                <div class="icon">📱</div>
                <div class="value"><?= $stats['total_products'] ?? 0 ?></div>
                <div class="label">Sản phẩm</div>
            </div>

            <div class="stat-card">
                <div class="icon">💰</div>
                <div class="value"><?= formatPrice($stats['total_revenue'] ?? 0) ?></div>
                <div class="label">Tổng doanh thu</div>
            </div>

            <div class="stat-card">
                <div class="icon">📊</div>
                <div class="value"><?= formatPrice($stats['monthly_revenue'] ?? 0) ?></div>
                <div class="label">Doanh thu tháng này</div>
            </div>
        </div>

        <div class="section">
            <h2>📋 Đơn hàng mới nhất</h2>
            <?php if (!empty($latestOrders)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latestOrders as $order): ?>
                            <tr>
                                <td>#<?= $order['id'] ?></td>
                                <td><?= escape($order['customer_name']) ?></td>
                                <td><?= formatPrice($order['total_amount']) ?></td>
                                <td>
                                    <span class="badge badge-<?= $order['status'] ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </td>
                                <td><?= formatDateTime($order['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Chưa có đơn hàng nào</p>
            <?php endif; ?>
        </div>

        <?php if (!empty($orderStatistics)): ?>
            <div class="section">
                <h2>📊 Thống kê đơn hàng theo trạng thái</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Trạng thái</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderStatistics as $stat): ?>
                            <tr>
                                <td>
                                    <span class="badge badge-<?= $stat['status'] ?>">
                                        <?= ucfirst($stat['status']) ?>
                                    </span>
                                </td>
                                <td><?= $stat['count'] ?></td>
                                <td><?= formatPrice($stat['total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="<?= config('app.base_url') ?>/resources/js/main.js"></script>
</body>

</html>