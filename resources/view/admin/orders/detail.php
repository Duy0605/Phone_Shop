<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Chi tiết đơn hàng' ?></title>
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
            padding: 0.8rem;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .info-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.3rem;
        }

        .info-value {
            font-weight: 600;
            color: #333;
        }

        .badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 12px;
            font-size: 0.9rem;
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

        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
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
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
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

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
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

        .status-form {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-top: 1rem;
        }

        .status-form select {
            padding: 0.7rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .total-row {
            background: #f8f9fa;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📄 Chi tiết đơn hàng #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></h1>
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

        <div style="margin-bottom: 1.5rem;">
            <a href="<?= config('app.base_url') ?>/admin/orders" class="btn btn-secondary">
                ← Quay lại danh sách
            </a>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="section">
            <div class="section-header">
                <h2>📋 Thông tin đơn hàng</h2>
                <span class="badge badge-<?= $order['status'] ?>">
                    <?= $order['status_text'] ?>
                </span>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Mã đơn hàng</div>
                    <div class="info-value">#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Ngày đặt hàng</div>
                    <div class="info-value"><?= formatDateTime($order['created_at']) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Phương thức thanh toán</div>
                    <div class="info-value">💵 <?= $order['payment_method'] ?? 'COD' ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Tổng tiền</div>
                    <div class="info-value" style="color: #667eea; font-size: 1.2rem;">
                        <?= formatPrice($order['total_amount']) ?>
                    </div>
                </div>
            </div>

            <?php if (!empty($order['notes'])): ?>
                <div style="margin-top: 1rem; padding: 1rem; background: #fff3cd; border-radius: 6px;">
                    <strong>📝 Ghi chú:</strong> <?= escape($order['notes']) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="section">
            <div class="section-header">
                <h2>👤 Thông tin khách hàng</h2>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Họ tên</div>
                    <div class="info-value"><?= escape($order['customer_name']) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Số điện thoại</div>
                    <div class="info-value">📱 <?= escape($order['customer_phone']) ?></div>
                </div>

                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">Địa chỉ nhận hàng</div>
                    <div class="info-value">📍 <?= escape($order['customer_address']) ?></div>
                </div>
            </div>
        </div>

        <!-- Sản phẩm -->
        <div class="section">
            <div class="section-header">
                <h2>📦 Sản phẩm đã đặt</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 70px;">Ảnh</th>
                        <th>Sản phẩm</th>
                        <th style="width: 120px;">Đơn giá</th>
                        <th style="width: 100px;">Số lượng</th>
                        <th style="width: 120px;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['product_image'])): ?>
                                    <img src="<?= config('app.base_url') ?>/<?= escape($item['product_image']) ?>"
                                        alt="<?= escape($item['product_name']) ?>" class="product-img">
                                <?php else: ?>
                                    <div class="product-img"
                                        style="background: #eee; display: flex; align-items: center; justify-content: center;">
                                        📱
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-weight: 500;"><?= escape($item['product_name']) ?></div>
                            </td>
                            <td style="font-weight: 500;">
                                <?= formatPrice($item['price']) ?>
                            </td>
                            <td style="text-align: center;">
                                <?= $item['quantity'] ?>
                            </td>
                            <td style="font-weight: 600; color: #667eea;">
                                <?= formatPrice($item['price'] * $item['quantity']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td colspan="4" style="text-align: right; padding-right: 1rem;">
                            Tổng cộng:
                        </td>
                        <td style="font-size: 1.1rem; color: #667eea;">
                            <?= formatPrice($order['total_amount']) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Cập nhật trạng thái -->
        <div class="section">
            <div class="section-header">
                <h2>⚙️ Quản lý đơn hàng</h2>
            </div>

            <form method="POST" action="/admin/orders/<?= $order['id'] ?>/status" class="status-form">
                <label style="font-weight: 600;">Cập nhật trạng thái:</label>
                <select name="status" <?= $order['status'] === 'cancelled' ? 'disabled' : '' ?>>
                    <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>⏳ Chờ xử lý</option>
                    <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>⚙️ Đang xử lý
                    </option>
                    <option value="shipping" <?= $order['status'] === 'shipping' ? 'selected' : '' ?>>🚚 Đang giao hàng
                    </option>
                    <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>✅ Đã giao hàng
                    </option>
                </select>

                <?php if ($order['status'] !== 'cancelled' && $order['status'] !== 'delivered'): ?>
                    <button type="submit" class="btn btn-success">
                        💾 Cập nhật
                    </button>
                <?php endif; ?>
            </form>

            <?php if ($order['status'] !== 'cancelled' && $order['status'] !== 'delivered'): ?>
                <form method="POST" action="/admin/orders/<?= $order['id'] ?>/cancel"
                    onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này? Stock sẽ được hoàn lại.')"
                    style="margin-top: 1rem;">
                    <button type="submit" class="btn btn-danger">
                        ❌ Hủy đơn hàng
                    </button>
                </form>
            <?php endif; ?>

            <?php if ($order['status'] === 'cancelled'): ?>
                <div style="margin-top: 1rem; padding: 1rem; background: #f8d7da; color: #842029; border-radius: 6px;">
                    ⚠️ Đơn hàng đã bị hủy. Không thể thay đổi trạng thái.
                </div>
            <?php endif; ?>

            <?php if ($order['status'] === 'delivered'): ?>
                <div style="margin-top: 1rem; padding: 1rem; background: #d1e7dd; color: #0f5132; border-radius: 6px;">
                    ✅ Đơn hàng đã được giao thành công.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>