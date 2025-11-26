<?php

namespace Controllers;

use Models\Cart;
use Models\CartItem;
use Models\Product;

/**
 * CartController
 * Xử lý giỏ hàng
 */
class CartController
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $cartModel = new Cart();
        $cartItemModel = new CartItem();

        $cart = $this->getOrCreateCart();

        if (!$cart) {
            $cartItems = [];
            $total = 0;
        } else {
            // Lấy items trong giỏ
            $cartItems = $cartItemModel->getCartItems($cart['id']);

            // Tính tổng tiền
            $total = $cartItemModel->calculateTotal($cart['id']);
        }

        $pageTitle = 'Giỏ hàng';
        require_once __DIR__ . '/../../resources/view/cart/index.php';
    }

    /**
     * Thêm sản phẩm vào giỏ
     */
    public function add()
    {
        if (!isMethod('POST')) {
            redirect('/cart');
        }

        $productId = (int) post('product_id');
        $quantity = max(1, (int) post('quantity', 1));

        // Validate product
        $productModel = new Product();
        $product = $productModel->find($productId);

        if (!$product) {
            setFlashMessage('error', 'Sản phẩm không tồn tại!');
            redirect('/products');
        }

        // Kiểm tra stock
        if (!$productModel->checkStock($productId, $quantity)) {
            setFlashMessage('error', 'Sản phẩm không đủ hàng trong kho!');
            redirect('/product/' . $product['slug']);
        }

        // Lấy hoặc tạo giỏ hàng
        $cart = $this->getOrCreateCart();

        // Thêm vào giỏ
        $cartItemModel = new CartItem();
        $added = $cartItemModel->addToCart($cart['id'], $productId, $quantity);

        if ($added) {
            setFlashMessage('success', 'Đã thêm sản phẩm vào giỏ hàng!');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }

        // Redirect về trang trước hoặc giỏ hàng
        $referer = $_SERVER['HTTP_REFERER'] ?? '/cart';
        redirect($referer);
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function update()
    {
        if (!isMethod('POST')) {
            redirect('/cart');
        }

        $productId = (int) post('product_id');
        $quantity = (int) post('quantity');

        if ($quantity < 0) {
            setFlashMessage('error', 'Số lượng không hợp lệ!');
            redirect('/cart');
        }

        $cart = $this->getOrCreateCart();

        // Kiểm tra stock nếu tăng số lượng
        if ($quantity > 0) {
            $productModel = new Product();
            if (!$productModel->checkStock($productId, $quantity)) {
                setFlashMessage('error', 'Không đủ hàng trong kho!');
                redirect('/cart');
            }
        }

        // Cập nhật
        $cartItemModel = new CartItem();
        $updated = $cartItemModel->updateQuantity($cart['id'], $productId, $quantity);

        if ($updated) {
            if ($quantity == 0) {
                setFlashMessage('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
            } else {
                setFlashMessage('success', 'Đã cập nhật giỏ hàng!');
            }
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
        }

        redirect('/cart');
    }

    /**
     * Xóa sản phẩm khỏi giỏ
     */
    public function remove()
    {
        if (!isMethod('POST')) {
            redirect('/cart');
        }

        $productId = (int) post('product_id');
        $cart = $this->getOrCreateCart();

        $cartItemModel = new CartItem();
        $removed = $cartItemModel->removeFromCart($cart['id'], $productId);

        if ($removed) {
            setFlashMessage('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
        }

        redirect('/cart');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        if (!isMethod('POST')) {
            redirect('/cart');
        }

        $cart = $this->getOrCreateCart();

        $cartItemModel = new CartItem();
        $cleared = $cartItemModel->clearCartItems($cart['id']);

        if ($cleared) {
            setFlashMessage('success', 'Đã xóa toàn bộ giỏ hàng!');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
        }

        redirect('/cart');
    }

    /**
     * Lấy hoặc tạo giỏ hàng (cho cả user và guest)
     * @return array|null
     */
    protected function getOrCreateCart()
    {
        $cartModel = new Cart();

        if (isAuthenticated()) {
            // User đã đăng nhập
            return $cartModel->getOrCreateCart(getUserId());
        } else {
            // Guest user - dùng session
            $sessionId = session_id();
            $cart = $cartModel->getCartBySession($sessionId);

            if (!$cart) {
                $cartId = $cartModel->createGuestCart($sessionId);
                $cart = $cartModel->find($cartId);
            }

            return $cart;
        }
    }
}
