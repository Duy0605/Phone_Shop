<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Quản lý khách hàng' ?></title>
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

        .badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            background: #e7f3ff;
            color: #667eea;
        }

        .stats-summary {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .stat-box {
            flex: 1;
            padding: 1rem;
            background: white;
            border-radius: 6px;
            text-align: center;
        }

        .stat-box .number {
            font-size: 2rem;
            font-weight: 600;
            color: #667eea;
        }

        .stat-box .label {
            color: #666;
            margin-top: 0.3rem;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>👥 Quản lý khách hàng - Phone Shop</h1>
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

        <div class="section">
            <div class="section-header">
                <div>
                    <h2>👥 Danh sách khách hàng</h2>
                    <p style="color: #666; margin-top: 0.5rem;">
                        Tổng: <strong><?= $pagination['total'] ?></strong> khách hàng
                    </p>
                </div>
            </div>

            <div class="stats-summary">
                <div class="stat-box">
                    <div class="number"><?= $pagination['total'] ?></div>
                    <div class="label">Tổng khách hàng</div>
                </div>
                <div class="stat-box">
                    <div class="number">
                        <?php
                        $activeCount = 0;
                        foreach ($customers as $c) {
                            // Khách hàng active là người đã đăng ký (có trong DB)
                            $activeCount++;
                        }
                        echo $activeCount;
                        ?>
                    </div>
                    <div class="label">Đã đăng ký</div>
                </div>
                <div class="stat-box">
                    <div class="number">
                        <?php
                        // Đếm khách hàng đăng ký trong tháng này
                        $thisMonth = date('Y-m');
                        $newThisMonth = 0;
                        foreach ($customers as $c) {
                            if (strpos($c['created_at'], $thisMonth) === 0) {
                                $newThisMonth++;
                            }
                        }
                        echo $newThisMonth;
                        ?>
                    </div>
                    <div class="label">Mới tháng này</div>
                </div>
            </div>

            <?php if (!empty($customers)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thông tin khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>
                            <th style="width: 120px; text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td style="font-weight: 600; color: #667eea;">
                                    #<?= str_pad($customer['id'], 4, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td>
                                    <div style="font-weight: 500; font-size: 1rem;">
                                        👤 <?= escape($customer['name']) ?>
                                    </div>
                                    <div style="font-size: 0.85rem; color: #666; margin-top: 0.2rem;">
                                        <span class="badge">Khách hàng</span>
                                    </div>
                                </td>
                                <td style="color: #666;">
                                    📱 <?= escape($customer['phone']) ?>
                                </td>
                                <td style="color: #666;">
                                    📧 <?= escape($customer['email']) ?>
                                </td>
                                <td style="color: #666; font-size: 0.9rem;">
                                    <?= formatDateTime($customer['created_at']) ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?= config('app.base_url') ?>/admin/customers/<?= $customer['id'] ?>"
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
                            <a href="?page=<?= $pagination['current_page'] - 1 ?>">
                                ‹ Trước
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                            <?php if ($i == $pagination['current_page']): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="?page=<?= $i ?>">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <a href="?page=<?= $pagination['current_page'] + 1 ?>">
                                Sau ›
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="no-data">
                    <p style="font-size: 3rem; margin-bottom: 1rem;">👥</p>
                    <p style="font-size: 1.2rem;">Chưa có khách hàng nào đăng ký</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>