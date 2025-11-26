<?php

namespace Models;

/**
 * Cart Model
 * Quản lý giỏ hàng
 */
class Cart extends BaseModel
{
    protected $table = 'carts';
    protected $primaryKey = 'id';

    /**
     * Lấy hoặc tạo giỏ hàng cho user
     * @param int $userId
     * @return array
     */
    public function getOrCreateCart($userId)
    {
        $cart = $this->findBy(['user_id' => $userId]);

        if (!$cart) {
            $cartId = $this->create(['user_id' => $userId]);
            $cart = $this->find($cartId);
        }

        return $cart;
    }

    /**
     * Lấy giỏ hàng theo session (cho guest)
     * @param string $sessionId
     * @return array|false
     */
    public function getCartBySession($sessionId)
    {
        return $this->findBy(['session_id' => $sessionId]);
    }

    /**
     * Tạo giỏ hàng cho guest
     * @param string $sessionId
     * @return int|false
     */
    public function createGuestCart($sessionId)
    {
        return $this->create(['session_id' => $sessionId]);
    }

    /**
     * Chuyển giỏ hàng guest sang user
     * @param string $sessionId
     * @param int $userId
     * @return bool
     */
    public function convertGuestCart($sessionId, $userId)
    {
        $guestCart = $this->getCartBySession($sessionId);

        if (!$guestCart) {
            return false;
        }

        // Cập nhật cart thành user cart
        $sql = "UPDATE {$this->table} 
                SET user_id = ?, session_id = NULL 
                WHERE session_id = ?";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([$userId, $sessionId]);
    }

    /**
     * Xóa giỏ hàng và các items
     * @param int $cartId
     * @return bool
     */
    public function clearCart($cartId)
    {
        // Xóa cart items trước
        $sql = "DELETE FROM cart_items WHERE cart_id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$cartId]);

        // Xóa cart
        return $this->delete($cartId);
    }
}
