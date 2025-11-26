<?php

namespace Models;

/**
 * Product Model
 * Quản lý sản phẩm điện thoại
 */
class Product extends BaseModel
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    /**
     * Tìm product theo slug
     * @param string $slug
     * @return array|false
     */
    public function findBySlug($slug)
    {
        return $this->findBy(['slug' => $slug]);
    }

    /**
     * Lấy sản phẩm kèm thông tin brand
     * @param int $id
     * @return array|false
     */
    public function findWithBrand($id)
    {
        $sql = "SELECT p.*, b.name as brand_name, b.slug as brand_slug 
                FROM {$this->table} p
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.id = ?
                LIMIT 1";

        return $this->queryOne($sql, [$id]);
    }

    /**
     * Lấy sản phẩm theo slug kèm brand
     * @param string $slug
     * @return array|false
     */
    public function findBySlugWithBrand($slug)
    {
        $sql = "SELECT p.*, b.name as brand_name, b.slug as brand_slug 
                FROM {$this->table} p
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.slug = ?
                LIMIT 1";

        return $this->queryOne($sql, [$slug]);
    }

    /**
     * Lấy tất cả sản phẩm kèm brand
     * @param array $filters ['brand_id', 'min_price', 'max_price', 'search']
     * @param string $orderBy
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllWithBrand($filters = [], $orderBy = 'created_at', $order = 'DESC', $limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, b.name as brand_name, b.slug as brand_slug 
                FROM {$this->table} p
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE 1=1";

        $params = [];

        // Filter theo brand
        if (!empty($filters['brand_id'])) {
            $sql .= " AND p.brand_id = ?";
            $params[] = $filters['brand_id'];
        }

        // Filter theo khoảng giá
        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= ?";
            $params[] = $filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= ?";
            $params[] = $filters['max_price'];
        }

        // Search theo tên
        if (!empty($filters['search'])) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        // Filter theo stock (chỉ lấy còn hàng)
        if (!empty($filters['in_stock'])) {
            $sql .= " AND p.stock > 0";
        }

        // Order
        $sql .= " ORDER BY p.{$orderBy} {$order}";

        // Limit & Offset
        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
        }

        return $this->query($sql, $params);
    }

    /**
     * Đếm số sản phẩm theo filters
     * @param array $filters
     * @return int
     */
    public function countProducts($filters = [])
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!empty($filters['brand_id'])) {
            $sql .= " AND brand_id = ?";
            $params[] = $filters['brand_id'];
        }

        if (!empty($filters['min_price'])) {
            $sql .= " AND price >= ?";
            $params[] = $filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $sql .= " AND price <= ?";
            $params[] = $filters['max_price'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (name LIKE ? OR description LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($filters['in_stock'])) {
            $sql .= " AND stock > 0";
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'] ?? 0;
    }

    /**
     * Lấy sản phẩm theo brand
     * @param int $brandId
     * @param int $limit
     * @return array
     */
    public function getByBrand($brandId, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE brand_id = ? ORDER BY created_at DESC";

        if ($limit) {
            $sql .= " LIMIT ?";
            return $this->query($sql, [$brandId, $limit]);
        }

        return $this->query($sql, [$brandId]);
    }

    /**
     * Lấy sản phẩm mới nhất
     * @param int $limit
     * @return array
     */
    public function getLatest($limit = 12)
    {
        $sql = "SELECT p.*, b.name as brand_name 
                FROM {$this->table} p
                LEFT JOIN brands b ON p.brand_id = b.id
                ORDER BY p.created_at DESC
                LIMIT ?";

        return $this->query($sql, [$limit]);
    }

    /**
     * Lấy sản phẩm nổi bật (giá cao, stock nhiều)
     * @param int $limit
     * @return array
     */
    public function getFeatured($limit = 8)
    {
        $sql = "SELECT p.*, b.name as brand_name 
                FROM {$this->table} p
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.stock > 0
                ORDER BY p.price DESC, p.stock DESC
                LIMIT ?";

        return $this->query($sql, [$limit]);
    }

    /**
     * Tạo sản phẩm mới
     * @param array $data
     * @return int|false
     */
    public function createProduct($data)
    {
        // Tự động tạo slug từ name nếu chưa có
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = createSlug($data['name']);
        }

        return $this->create($data);
    }

    /**
     * Cập nhật sản phẩm
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateProduct($id, $data)
    {
        // Tự động tạo slug từ name nếu chưa có
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = createSlug($data['name']);
        }

        return $this->update($id, $data);
    }

    /**
     * Giảm stock khi bán hàng
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function decreaseStock($productId, $quantity)
    {
        $sql = "UPDATE {$this->table} 
                SET stock = stock - ? 
                WHERE id = ? AND stock >= ?";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([$quantity, $productId, $quantity]);
    }

    /**
     * Tăng stock khi hủy đơn
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function increaseStock($productId, $quantity)
    {
        $sql = "UPDATE {$this->table} SET stock = stock + ? WHERE id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([$quantity, $productId]);
    }

    /**
     * Kiểm tra còn đủ hàng không
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function checkStock($productId, $quantity)
    {
        $product = $this->find($productId);
        return $product && $product['stock'] >= $quantity;
    }
}
