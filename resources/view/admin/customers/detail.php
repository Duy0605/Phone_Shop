<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Chi tiết khách hàng' ?></title>
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
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-header h2 {
            color: #333;
            font-size: 1.3rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .info-item {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .info-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-weight: 600;
            color: #333;
            font-size: 1rem;
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

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .stat-card {
            padding: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stat-card .label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        table th {
            background: #f8f9fa;
            padding: 0.8rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }

        table td {
            padding: 0.8rem;
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

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #999;
        }

        .customer-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            margin: 0 auto 1rem;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>👤 Chi tiết khách hàng - Phone Shop</h1>
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
        <a href="<?= config('app.base_url') ?>/admin/orders">Đơn hàng</a>
        <a href="<?= config('app.base_url') ?>/admin/customers" style="color: #764ba2; font-weight: 600;">Khách hàng</a>
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

        <div style="margin-bottom: 1.5rem;">
            <a href="<?= config('app.base_url') ?>/admin/customers" class="btn btn-secondary">
                ← Quay lại danh sách
            </a>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="section">
            <div class="section-header">
                <h2>📋 Thông tin cá nhân</h2>
            </div>

            <div class="customer-avatar">
                <?= strtoupper(substr($customer['name'], 0, 1)) ?>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Mã khách hàng</div>
                    <div class="info-value">#<?= str_pad($customer['id'], 4, '0', STR_PAD_LEFT) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Ngày đăng ký</div>
                    <div class="info-value"><?= formatDateTime($customer['created_at']) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Họ và tên</div>
                    <div class="info-value"><?= escape($customer['name']) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Số điện thoại</div>
                    <div class="info-value">📱 <?= escape($customer['phone']) ?></div>
                </div>

                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">Email</div>
                    <div class="info-value">📧 <?= escape($customer['email']) ?></div>
                </div>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="number"><?= count($orders) ?></div>
                    <div class="label">Tổng đơn hàng</div>
                </div>
                <div class="stat-card">
                    <div class="number">
                        <?php
                        $completedOrders = 0;
                        foreach ($orders as $o) {
                            if ($o['status'] === 'delivered')
                                $completedOrders++;
                        }
                        echo $completedOrders;
                        ?>
                    </div>
                    <div class="label">Đơn thành công</div>
                </div>
                <div class="stat-card">
                    <div class="number"><?= formatPrice($totalSpent) ?></div>
                    <div class="label">Tổng chi tiêu</div>
                </div>
            </div>
        </div>

        <!-- Lịch sử đơn hàng -->
        <div class="section">
            <div class="section-header">
                <h2>📦 Lịch sử đơn hàng</h2>
            </div>

            <?php if (!empty($orders)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th style="width: 100px; text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td style="font-weight: 600; color: #667eea;">
                                    #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td style="color: #666; font-size: 0.9rem;">
                                    <?= formatDateTime($order['created_at']) ?>
                                </td>
                                <td style="font-weight: 600; color: #667eea;">
                                    <?= formatPrice($order['total_amount']) ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $order['status'] ?>">
                                        <?php
                                        $statusMap = [
                                            'pending' => '⏳ Chờ xử lý',
                                            'processing' => '⚙️ Đang xử lý',
                                            'shipping' => '🚚 Đang giao',
                                            'delivered' => '✅ Đã giao',
                                            'cancelled' => '❌ Đã hủy'
                                        ];
                                        echo $statusMap[$order['status']] ?? $order['status'];
                                        ?>
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?= config('app.base_url') ?>/admin/orders/<?= $order['id'] ?>"
                                        class="btn btn-primary btn-sm"
                                        style="background: #667eea; color: white; padding: 0.4rem 0.8rem; text-decoration: none; border-radius: 6px; font-size: 0.85rem;">
                                        👁️ Xem
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <p style="font-size: 2rem; margin-bottom: 0.5rem;">📦</p>
                    <p>Khách hàng chưa có đơn hàng nào</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>