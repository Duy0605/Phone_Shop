<?php

namespace Controllers\Admin;

use Middleware\AdminMiddleware;
use Models\Order;
use Models\User;
use Models\Product;

/**
 * Admin DashboardController
 * Trang chủ quản trị - Thống kê tổng quan
 */
class DashboardController
{
    /**
     * Hiển thị dashboard
     */
    public function index()
    {
        AdminMiddleware::check();

        $orderModel = new Order();
        $userModel = new User();
        $productModel = new Product();

        // Thống kê tổng quan
        $stats = [
            'total_orders' => $orderModel->count(),
            'pending_orders' => $orderModel->count(['status' => 'pending']),
            'total_customers' => $userModel->countCustomers(),
            'total_products' => $productModel->count(),
            'total_revenue' => $orderModel->getTotalRevenue(),
        ];

        // Thống kê theo status
        $orderStatistics = $orderModel->getOrderStatistics();

        // Đơn hàng mới nhất
        $latestOrders = $orderModel->getOrdersPaginated([], 10, 0);

        // Doanh thu tháng này
        $currentMonth = date('Y-m-01');
        $stats['monthly_revenue'] = $orderModel->getTotalRevenue([
            'start_date' => $currentMonth,
            'status' => 'delivered'
        ]);

        // Doanh thu hôm nay
        $today = date('Y-m-d');
        $stats['daily_revenue'] = $orderModel->getTotalRevenue([
            'start_date' => $today,
            'end_date' => $today,
            'status' => 'delivered'
        ]);

        $pageTitle = 'Dashboard - Admin';
        require_once __DIR__ . '/../../../../resources/view/admin/dashboard.php';
    }
}
