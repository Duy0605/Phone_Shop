<?php

namespace Controllers;

use Models\Order;
use Models\Cart;
use Models\CartItem;

/**
 * OrderController
 * Xử lý đơn hàng và checkout
 */
class OrderController
{
    /**
     * Hiển thị trang checkout
     */
    public function showCheckout()
    {
        requireAuth();

        $cartModel = new Cart();
        $cartItemModel = new CartItem();

        // Lấy giỏ hàng
        $cart = $cartModel->getOrCreateCart(getUserId());
        $cartItems = $cartItemModel->getCartItems($cart['id']);

        // Kiểm tra giỏ hàng có rỗng không
        if (empty($cartItems)) {
            setFlashMessage('warning', 'Giỏ hàng của bạn đang trống!');
            redirect('/products');
        }

        // Validate stock
        $stockValidation = $cartItemModel->validateStock($cart['id']);
        if (!$stockValidation['valid']) {
            setFlashMessage('error', implode('<br>', $stockValidation['errors']));
            redirect('/cart');
        }

        // Tính tổng tiền
        $total = $cartItemModel->calculateTotal($cart['id']);

        $pageTitle = 'Thanh toán';
        require_once __DIR__ . '/../../../resources/view/checkout.php';
    }

    /**
     * Xử lý đặt hàng
     */
    public function processCheckout()
    {
        requireAuth();

        if (!isMethod('POST')) {
            redirect('/checkout');
        }

        $customerName = post('customer_name');
        $customerPhone = post('customer_phone');
        $customerAddress = post('customer_address');
        $notes = post('notes');

        // Validate
        $errors = [];

        if (!validateRequired($customerName)) {
            $errors[] = 'Vui lòng nhập họ tên người nhận';
        }

        if (!validatePhone($customerPhone)) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }

        if (!validateRequired($customerAddress)) {
            $errors[] = 'Vui lòng nhập địa chỉ giao hàng';
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/checkout');
        }

        // Lấy giỏ hàng
        $cartModel = new Cart();
        $cartItemModel = new CartItem();
        $cart = $cartModel->getOrCreateCart(getUserId());
        $cartItems = $cartItemModel->getCartItems($cart['id']);

        if (empty($cartItems)) {
            setFlashMessage('error', 'Giỏ hàng đang trống!');
            redirect('/products');
        }

        // Validate stock lần cuối
        $stockValidation = $cartItemModel->validateStock($cart['id']);
        if (!$stockValidation['valid']) {
            setFlashMessage('error', implode('<br>', $stockValidation['errors']));
            redirect('/cart');
        }

        // Tạo đơn hàng
        $orderModel = new Order();
        $customerInfo = [
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_address' => $customerAddress,
            'notes' => $notes
        ];

        $orderId = $orderModel->createOrder(getUserId(), $customerInfo, $cartItems);

        if ($orderId) {
            // Xóa giỏ hàng sau khi đặt hàng thành công
            $cartItemModel->clearCartItems($cart['id']);

            setFlashMessage('success', 'Đặt hàng thành công! Mã đơn hàng: #' . $orderId);
            redirect('/order/' . $orderId);
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!');
            redirect('/checkout');
        }
    }

    /**
     * Hiển thị danh sách đơn hàng của user
     */
    public function myOrders()
    {
        requireAuth();

        $orderModel = new Order();

        // Lấy đơn hàng của user
        $orders = $orderModel->getUserOrders(getUserId());

        $pageTitle = 'Đơn hàng của tôi';
        require_once __DIR__ . '/../../../resources/view/orders/index.php';
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function detail($orderId)
    {
        requireAuth();

        $orderModel = new Order();

        // Lấy đơn hàng
        $order = $orderModel->getOrderWithItems($orderId);

        if (!$order) {
            setFlashMessage('error', 'Đơn hàng không tồn tại!');
            redirect('/orders');
        }

        // Kiểm tra quyền xem đơn hàng
        if ($order['user_id'] != getUserId() && !isAdmin()) {
            setFlashMessage('error', 'Bạn không có quyền xem đơn hàng này!');
            redirect('/orders');
        }

        // Map trạng thái sang tiếng Việt
        $statusMap = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy'
        ];

        $order['status_text'] = $statusMap[$order['status']] ?? $order['status'];

        $pageTitle = 'Chi tiết đơn hàng #' . $orderId;
        require_once __DIR__ . '/../../../resources/view/orders/detail.php';
    }
}
