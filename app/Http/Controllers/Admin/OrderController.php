<?php

namespace Controllers\Admin;

use Middleware\AdminMiddleware;
use Models\Order;

/**
 * Admin OrderController
 * Quản lý đơn hàng
 */
class OrderController
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
    {
        AdminMiddleware::check();

        $orderModel = new Order();

        // Pagination
        $page = max(1, (int) get('page', 1));
        $perPage = config('app.pagination.per_page_admin', 20);

        // Filters
        $filters = [];
        $status = get('status');
        $search = get('search');

        if ($status) {
            $filters['status'] = $status;
        }

        if ($search) {
            $filters['search'] = $search;
        }

        $total = $orderModel->countOrders($filters);
        $pagination = paginate($total, $perPage, $page);

        // Lấy orders
        $orders = $orderModel->getOrdersPaginated($filters, $perPage, $pagination['offset']);

        // Map status
        $statusMap = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy'
        ];

        $pageTitle = 'Quản lý đơn hàng - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/orders/index.php';
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function detail($id)
    {
        AdminMiddleware::check();

        $orderModel = new Order();
        $order = $orderModel->getOrderWithItems($id);

        if (!$order) {
            setFlashMessage('error', 'Đơn hàng không tồn tại!');
            redirect('/admin/orders');
        }

        // Map status
        $statusMap = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy'
        ];

        $order['status_text'] = $statusMap[$order['status']] ?? $order['status'];

        $pageTitle = 'Chi tiết đơn hàng #' . $id . ' - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/orders/detail.php';
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus($id)
    {
        AdminMiddleware::check();

        if (!isMethod('POST')) {
            redirect('/admin/orders/' . $id);
        }

        $status = post('status');

        $validStatuses = ['pending', 'processing', 'shipping', 'delivered', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            setFlashMessage('error', 'Trạng thái không hợp lệ!');
            redirect('/admin/orders/' . $id);
        }

        $orderModel = new Order();
        $updated = $orderModel->updateStatus($id, $status);

        if ($updated) {
            setFlashMessage('success', 'Cập nhật trạng thái đơn hàng thành công!');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
        }

        redirect('/admin/orders/' . $id);
    }

    /**
     * Hủy đơn hàng
     */
    public function cancel($id)
    {
        AdminMiddleware::check();

        if (!isMethod('POST')) {
            redirect('/admin/orders/' . $id);
        }

        $orderModel = new Order();
        $cancelled = $orderModel->cancelOrder($id);

        if ($cancelled) {
            setFlashMessage('success', 'Hủy đơn hàng thành công! Stock đã được hoàn lại.');
        } else {
            setFlashMessage('error', 'Không thể hủy đơn hàng này!');
        }

        redirect('/admin/orders/' . $id);
    }
}
