<?php

namespace Models;

/**
 * CartItem Model
 * Quản lý sản phẩm trong giỏ hàng
 */
class CartItem extends BaseModel
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';

    /**
     * Lấy tất cả items trong giỏ kèm thông tin sản phẩm
     * @param int $cartId
     * @return array
     */
    public function getCartItems($cartId)
    {
        $sql = "SELECT ci.*, 
                p.name as product_name, 
                p.slug as product_slug, 
                p.price as product_price, 
                p.image as product_image, 
                p.stock as product_stock, 
                b.name as brand_name
                FROM {$this->table} ci
                INNER JOIN products p ON ci.product_id = p.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE ci.cart_id = ?
                ORDER BY ci.created_at DESC";

        return $this->query($sql, [$cartId]);
    }

    /**
     * Lấy 1 item cụ thể trong giỏ
     * @param int $cartId
     * @param int $productId
     * @return array|false
     */
    public function getCartItem($cartId, $productId)
    {
        return $this->findBy([
            'cart_id' => $cartId,
            'product_id' => $productId
        ]);
    }

    /**
     * Thêm sản phẩm vào giỏ
     * @param int $cartId
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function addToCart($cartId, $productId, $quantity = 1)
    {
        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $existingItem = $this->getCartItem($cartId, $productId);

        if ($existingItem) {
            // Nếu đã có, tăng số lượng
            return $this->updateQuantity($cartId, $productId, $existingItem['quantity'] + $quantity);
        } else {
            // Nếu chưa có, thêm mới
            return $this->create([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
    }

    /**
     * Cập nhật số lượng sản phẩm
     * @param int $cartId
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function updateQuantity($cartId, $productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($cartId, $productId);
        }

        $sql = "UPDATE {$this->table} 
                SET quantity = ? 
                WHERE cart_id = ? AND product_id = ?";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([$quantity, $cartId, $productId]);
    }

    /**
     * Xóa sản phẩm khỏi giỏ
     * @param int $cartId
     * @param int $productId
     * @return bool
     */
    public function removeFromCart($cartId, $productId)
    {
        $sql = "DELETE FROM {$this->table} 
                WHERE cart_id = ? AND product_id = ?";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([$cartId, $productId]);
    }

    /**
     * Xóa tất cả items trong giỏ
     * @param int $cartId
     * @return bool
     */
    public function clearCartItems($cartId)
    {
        $sql = "DELETE FROM {$this->table} WHERE cart_id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([$cartId]);
    }

    /**
     * Đếm số sản phẩm trong giỏ
     * @param int $cartId
     * @return int
     */
    public function countItems($cartId)
    {
        return $this->count(['cart_id' => $cartId]);
    }

    /**
     * Tính tổng tiền giỏ hàng
     * @param int $cartId
     * @return float
     */
    public function calculateTotal($cartId)
    {
        $sql = "SELECT SUM(ci.quantity * p.price) as total
                FROM {$this->table} ci
                INNER JOIN products p ON ci.product_id = p.id
                WHERE ci.cart_id = ?";

        $result = $this->queryOne($sql, [$cartId]);
        return $result['total'] ?? 0;
    }

    /**
     * Kiểm tra tất cả items có đủ hàng không
     * @param int $cartId
     * @return array ['valid' => bool, 'errors' => array]
     */
    public function validateStock($cartId)
    {
        $items = $this->getCartItems($cartId);
        $errors = [];

        foreach ($items as $item) {
            if ($item['stock'] < $item['quantity']) {
                $errors[] = "Sản phẩm '{$item['name']}' chỉ còn {$item['stock']} trong kho";
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
