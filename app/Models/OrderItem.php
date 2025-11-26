<?php

namespace Models;

/**
 * OrderItem Model
 * Quản lý chi tiết sản phẩm trong đơn hàng
 */
class OrderItem extends BaseModel
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';

    /**
     * Lấy tất cả items của đơn hàng
     * @param int $orderId
     * @return array
     */
    public function getOrderItems($orderId)
    {
        $sql = "SELECT oi.*, p.image, p.slug 
                FROM {$this->table} oi
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?
                ORDER BY oi.id ASC";

        return $this->query($sql, [$orderId]);
    }

    /**
     * Tính tổng tiền của đơn hàng
     * @param int $orderId
     * @return float
     */
    public function calculateOrderTotal($orderId)
    {
        $sql = "SELECT SUM(quantity * price) as total 
                FROM {$this->table} 
                WHERE order_id = ?";

        $result = $this->queryOne($sql, [$orderId]);
        return $result['total'] ?? 0;
    }

    /**
     * Lấy sản phẩm bán chạy nhất
     * @param int $limit
     * @return array
     */
    public function getBestSellingProducts($limit = 10)
    {
        $sql = "SELECT p.id, p.name, p.slug, p.image, p.price, 
                       SUM(oi.quantity) as total_sold,
                       COUNT(DISTINCT oi.order_id) as order_count
                FROM {$this->table} oi
                INNER JOIN products p ON oi.product_id = p.id
                INNER JOIN orders o ON oi.order_id = o.id
                WHERE o.status != 'cancelled'
                GROUP BY p.id
                ORDER BY total_sold DESC
                LIMIT ?";

        return $this->query($sql, [$limit]);
    }

    /**
     * Thống kê doanh thu theo sản phẩm
     * @param array $filters ['start_date', 'end_date']
     * @param int $limit
     * @return array
     */
    public function getProductRevenue($filters = [], $limit = 20)
    {
        $sql = "SELECT p.id, p.name, p.slug,
                       SUM(oi.quantity) as total_quantity,
                       SUM(oi.quantity * oi.price) as total_revenue
                FROM {$this->table} oi
                INNER JOIN products p ON oi.product_id = p.id
                INNER JOIN orders o ON oi.order_id = o.id
                WHERE o.status != 'cancelled'";

        $params = [];

        if (!empty($filters['start_date'])) {
            $sql .= " AND DATE(o.created_at) >= ?";
            $params[] = $filters['start_date'];
        }

        if (!empty($filters['end_date'])) {
            $sql .= " AND DATE(o.created_at) <= ?";
            $params[] = $filters['end_date'];
        }

        $sql .= " GROUP BY p.id ORDER BY total_revenue DESC LIMIT ?";
        $params[] = $limit;

        return $this->query($sql, $params);
    }
}
