<?php
/**
 * Order Status Badge Component
 * 
 * @param string $status Order status (pending, processing, shipping, delivered, cancelled)
 */

$statusLabels = [
    'pending' => '⏳ Chờ xử lý',
    'processing' => '⚙️ Đang xử lý',
    'shipping' => '🚚 Đang giao',
    'delivered' => '✅ Đã giao',
    'cancelled' => '❌ Đã hủy'
];

$label = $statusLabels[$status] ?? $status;
?>

<span class="badge badge-<?= escape($status) ?>">
    <?= escape($label) ?>
</span>