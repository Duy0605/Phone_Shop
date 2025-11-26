<?php

namespace Controllers\Admin;

use Middleware\AdminMiddleware;
use Models\User;
use Models\Order;

/**
 * Admin CustomerController
 * Quản lý khách hàng
 */
class CustomerController
{
    /**
     * Hiển thị danh sách khách hàng
     */
    public function index()
    {
        AdminMiddleware::check();

        $userModel = new User();

        // Pagination
        $page = max(1, (int) get('page', 1));
        $perPage = config('app.pagination.per_page_admin', 20);

        $total = $userModel->countCustomers();
        $pagination = paginate($total, $perPage, $page);

        // Lấy customers
        $customers = $userModel->getCustomersPaginated($perPage, $pagination['offset']);

        $pageTitle = 'Quản lý khách hàng - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/customers/index.php';
    }

    /**
     * Hiển thị chi tiết khách hàng
     */
    public function detail($id)
    {
        AdminMiddleware::check();

        $userModel = new User();
        $customer = $userModel->find($id);

        if (!$customer || $customer['role'] !== 'customer') {
            setFlashMessage('error', 'Khách hàng không tồn tại!');
            redirect('/admin/customers');
        }

        // Lấy đơn hàng của khách hàng
        $orderModel = new Order();
        $orders = $orderModel->getUserOrders($id);

        // Tính tổng đã mua
        $totalSpent = 0;
        foreach ($orders as $order) {
            if ($order['status'] !== 'cancelled') {
                $totalSpent += $order['total_amount'];
            }
        }

        $pageTitle = 'Chi tiết khách hàng - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/customers/detail.php';
    }
}
