<?php
$pageTitle = 'Đơn hàng của tôi - Phone Shop';
$pageCSS = ['orders'];
include __DIR__ . '/../layouts/header-component.php';
?>

<div class="container">
    <h1>📦 Đơn hàng của tôi</h1>

    <?php if (empty($orders)): ?>
        <div class="empty-orders">
            <div style="font-size: 5rem;">📦</div>
            <h2>Chưa có đơn hàng</h2>
            <p>Bạn chưa có đơn hàng nào</p>
            <a href="<?= url('/products') ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h3>Đơn hàng #<?= $order['id'] ?></h3>
                            <p class="order-date">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                        <div>
                            <?php
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
                            <span class="badge <?= $statusClass[$order['status']] ?>">
                                <?= $statusText[$order['status']] ?>
                            </span>
                        </div>
                    </div>

                    <div class="order-info">
                        <p><strong>Tổng tiền:</strong> <?= formatPrice($order['total_amount']) ?></p>
                        <p><strong>Thanh toán:</strong> <?= $order['payment_method'] === 'cod' ? 'Tiền mặt' : 'Chuyển khoản' ?>
                        </p>
                    </div>

                    <div class="order-actions">
                        <a href="<?= url('/orders/' . $order['id']) ?>" class="btn btn-detail">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer-component.php'; ?>