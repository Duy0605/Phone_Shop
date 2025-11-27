<?php
$pageTitle = 'Chi tiết đơn hàng #' . $order['id'] . ' - Phone Shop';
$pageCSS = ['orders'];
include __DIR__ . '/../layouts/header-component.php';

$statusClass = [
    'pending' => 'badge-warning',
    'confirmed' => 'badge-info',
    'shipping' => 'badge-primary',
    'completed' => 'badge-success',
    'cancelled' => 'badge-danger'
];
$statusText = [
    'pending' => 'Chờ xác nhận',
    'confirmed' => 'Đã xác nhận',
    'shipping' => 'Đang giao',
    'completed' => 'Hoàn thành',
    'cancelled' => 'Đã hủy'
];
?>

<div class="container">
    <div class="order-detail-header">
        <h1>📦 Chi tiết đơn hàng #<?= $order['id'] ?></h1>
        <span class="badge <?= $statusClass[$order['status']] ?>">
            <?= $statusText[$order['status']] ?>
        </span>
    </div>

    <div class="order-timeline">
        <div
            class="timeline-item <?= in_array($order['status'], ['pending', 'confirmed', 'shipping', 'completed']) ? 'active' : '' ?>">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <h4>Đơn hàng đã đặt</h4>
                <p><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
            </div>
        </div>

        <div
            class="timeline-item <?= in_array($order['status'], ['confirmed', 'shipping', 'completed']) ? 'active' : '' ?>">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <h4>Đã xác nhận</h4>
                <p><?= $order['status'] !== 'pending' && $order['status'] !== 'cancelled' ? 'Đã xác nhận' : 'Chưa xác nhận' ?>
                </p>
            </div>
        </div>

        <div class="timeline-item <?= in_array($order['status'], ['shipping', 'completed']) ? 'active' : '' ?>">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <h4>Đang giao hàng</h4>
                <p><?= in_array($order['status'], ['shipping', 'completed']) ? 'Đang vận chuyển' : 'Chưa vận chuyển' ?>
                </p>
            </div>
        </div>

        <div class="timeline-item <?= $order['status'] === 'completed' ? 'active' : '' ?>">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <h4>Hoàn thành</h4>
                <p><?= $order['status'] === 'completed' ? 'Đã giao hàng' : 'Chưa hoàn thành' ?></p>
            </div>
        </div>
    </div>

    <div class="order-detail-grid">
        <div class="order-products">
            <h2>Sản phẩm</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td>
                                <div class="product-info-row">
                                    <?php if (!empty($item['product_image'])): ?>
                                        <img src="<?= config('app.base_url') ?>/<?= escape($item['product_image']) ?>"
                                            alt="<?= escape($item['product_name']) ?>" class="product-thumbnail">
                                    <?php else: ?>
                                        <div class="product-thumbnail no-image">📱</div>
                                    <?php endif; ?>
                                    <span><?= escape($item['product_name']) ?></span>
                                </div>
                            </td>
                            <td><?= formatPrice($item['price']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= formatPrice($item['price'] * $item['quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="order-info-card">
            <h2>Thông tin đơn hàng</h2>
            <div class="info-row">
                <span>Mã đơn:</span>
                <strong>#<?= $order['id'] ?></strong>
            </div>
            <div class="info-row">
                <span>Ngày đặt:</span>
                <span><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
            </div>
            <div class="info-row">
                <span>Thanh toán:</span>
                <span><?= $order['payment_method'] === 'cod' ? 'Tiền mặt' : 'Chuyển khoản' ?></span>
            </div>

            <h3>Thông tin nhận hàng</h3>
            <div class="info-row">
                <span>Người nhận:</span>
                <span><?= escape($order['customer_name']) ?></span>
            </div>
            <div class="info-row">
                <span>Điện thoại:</span>
                <span><?= escape($order['customer_phone']) ?></span>
            </div>
            <div class="info-row">
                <span>Địa chỉ:</span>
                <span><?= escape($order['customer_address']) ?></span>
            </div>

            <h3>Tổng tiền</h3>
            <div class="info-row">
                <span>Tạm tính:</span>
                <span><?= formatPrice($order['total_amount']) ?></span>
            </div>
            <div class="info-row">
                <span>Phí vận chuyển:</span>
                <span>Miễn phí</span>
            </div>
            <div class="info-row total">
                <strong>Tổng cộng:</strong>
                <strong><?= formatPrice($order['total_amount']) ?></strong>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 2rem;">
        <a href="<?= url('/orders') ?>" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>