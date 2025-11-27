<?php

namespace Models;

/**
 * Order Model
 * Quản lý đơn hàng
 */
class Order extends BaseModel
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    /**
     * Tạo đơn hàng mới từ giỏ hàng
     * @param int $userId
     * @param array $customerInfo ['customer_name', 'customer_phone', 'customer_address', 'notes']
     * @param array $cartItems Danh sách items từ giỏ hàng
     * @param array $selectedItemIds Danh sách item IDs được chọn để xóa
     * @return int|false Order ID hoặc false
     */
    public function createOrder($userId, $customerInfo, $cartItems, $selectedItemIds = [])
    {
        $this->beginTransaction();

        try {
            // Validate stock
            $productModel = new Product();
            foreach ($cartItems as $item) {
                if (!$productModel->checkStock($item['product_id'], $item['quantity'])) {
                    throw new \Exception("Sản phẩm '{$item['product_name']}' không đủ hàng");
                }
            }

            // Tính tổng tiền
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item['product_price'] * $item['quantity'];
            }

            // Tạo order
            $orderData = [
                'user_id' => $userId,
                'customer_name' => $customerInfo['customer_name'],
                'customer_phone' => $customerInfo['customer_phone'],
                'customer_address' => $customerInfo['customer_address'],
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => 'COD',
                'notes' => $customerInfo['notes'] ?? null
            ];

            $orderId = $this->create($orderData);

            if (!$orderId) {
                throw new \Exception("Không thể tạo đơn hàng");
            }

            // Tạo order items
            $orderItemModel = new OrderItem();
            foreach ($cartItems as $item) {
                $orderItemModel->create([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['product_price']
                ]);

                // Giảm stock
                $productModel->decreaseStock($item['product_id'], $item['quantity']);
            }

            // Xóa các cart items đã đặt hàng
            if (!empty($selectedItemIds)) {
                $cartItemModel = new CartItem();
                foreach ($selectedItemIds as $itemId) {
                    $cartItemModel->delete($itemId);
                }
            }

            $this->commit();
            return $orderId;

        } catch (\Exception $e) {
            $this->rollback();
            return false;
        }
    }

    /**
     * Lấy đơn hàng kèm items
     * @param int $orderId
     * @return array|false
     */
    public function getOrderWithItems($orderId)
    {
        $order = $this->find($orderId);

        if (!$order) {
            return false;
        }

        $orderItemModel = new OrderItem();
        $order['items'] = $orderItemModel->getOrderItems($orderId);

        return $order;
    }

    /**
     * Lấy tất cả đơn hàng của user
     * @param int $userId
     * @param string $orderBy
     * @return array
     */
    public function getUserOrders($userId, $orderBy = 'created_at', $order = 'DESC')
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = ? 
                ORDER BY {$orderBy} {$order}";

        return $this->query($sql, [$userId]);
    }

    /**
     * Lấy đơn hàng với phân trang
     * @param array $filters ['status', 'search']
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getOrdersPaginated($filters = [], $limit = 20, $offset = 0)
    {
        $sql = "SELECT o.*, u.name as user_name, u.email as user_email
                FROM {$this->table} o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE 1=1";

        $params = [];

        // Filter theo status
        if (!empty($filters['status'])) {
            $sql .= " AND o.status = ?";
            $params[] = $filters['status'];
        }

        // Search theo customer name, phone
        if (!empty($filters['search'])) {
            $sql .= " AND (o.customer_name LIKE ? OR o.customer_phone LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $sql .= " ORDER BY o.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        return $this->query($sql, $params);
    }

    /**
     * Đếm số đơn hàng
     * @param array $filters
     * @return int
     */
    public function countOrders($filters = [])
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (customer_name LIKE ? OR customer_phone LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'] ?? 0;
    }

    /**
     * Cập nhật trạng thái đơn hàng
     * @param int $orderId
     * @param string $status
     * @return bool
     */
    public function updateStatus($orderId, $status)
    {
        $validStatuses = ['pending', 'processing', 'shipping', 'delivered', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return false;
        }

        return $this->update($orderId, ['status' => $status]);
    }

    /**
     * Hủy đơn hàng (trả lại stock)
     * @param int $orderId
     * @return bool
     */
    public function cancelOrder($orderId)
    {
        $this->beginTransaction();

        try {
            $order = $this->find($orderId);

            if (!$order || $order['status'] === 'cancelled') {
                throw new \Exception("Không thể hủy đơn hàng");
            }

            // Cập nhật status
            $this->update($orderId, ['status' => 'cancelled']);

            // Trả lại stock
            $orderItemModel = new OrderItem();
            $items = $orderItemModel->getOrderItems($orderId);

            $productModel = new Product();
            foreach ($items as $item) {
                $productModel->increaseStock($item['product_id'], $item['quantity']);
            }

            $this->commit();
            return true;

        } catch (\Exception $e) {
            $this->rollback();
            return false;
        }
    }

    /**
     * Tính tổng doanh thu
     * @param array $filters ['start_date', 'end_date', 'status']
     * @return float
     */
    public function getTotalRevenue($filters = [])
    {
        $sql = "SELECT SUM(total_amount) as revenue FROM {$this->table} 
                WHERE status = 'delivered'";

        $params = [];

        if (!empty($filters['start_date'])) {
            $sql .= " AND DATE(created_at) >= ?";
            $params[] = $filters['start_date'];
        }

        if (!empty($filters['end_date'])) {
            $sql .= " AND DATE(created_at) <= ?";
            $params[] = $filters['end_date'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }

        $result = $this->queryOne($sql, $params);
        return $result['revenue'] ?? 0;
    }

    /**
     * Thống kê đơn hàng theo trạng thái
     * @return array
     */
    public function getOrderStatistics()
    {
        $sql = "SELECT status, COUNT(*) as count, SUM(total_amount) as total 
                FROM {$this->table} 
                GROUP BY status";

        return $this->query($sql);
    }
}
