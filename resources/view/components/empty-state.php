<?php
/**
 * Empty State Component
 * 
 * @param string $icon Emoji icon to display
 * @param string $title Main title
 * @param string $message Description message
 * @param string $buttonText Optional button text
 * @param string $buttonUrl Optional button URL
 */

$icon = $icon ?? '📦';
$title = $title ?? 'Không có dữ liệu';
$message = $message ?? 'Chưa có dữ liệu nào được tìm thấy';
?>

<div class="empty-state">
    <div style="font-size: 5rem;"><?= escape($icon) ?></div>
    <h3><?= escape($title) ?></h3>
    <p><?= escape($message) ?></p>
    <?php if (isset($buttonText) && isset($buttonUrl)): ?>
        <a href="<?= url($buttonUrl) ?>" class="btn btn-primary" style="margin-top: 1rem;">
            <?= escape($buttonText) ?>
        </a>
    <?php endif; ?>
</div>