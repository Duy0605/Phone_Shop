<?php

namespace Models;

/**
 * Brand Model
 * Quản lý thông tin thương hiệu điện thoại
 */
class Brand extends BaseModel
{
    protected $table = 'brands';
    protected $primaryKey = 'id';

    /**
     * Tìm brand theo slug
     * @param string $slug
     * @return array|false
     */
    public function findBySlug($slug)
    {
        return $this->findBy(['slug' => $slug]);
    }

    /**
     * Kiểm tra slug đã tồn tại chưa
     * @param string $slug
     * @param int $excludeId
     * @return bool
     */
    public function slugExists($slug, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE slug = ?";
        $params = [$slug];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'] > 0;
    }

    /**
     * Tạo brand mới
     * @param array $data
     * @return int|false
     */
    public function createBrand($data)
    {
        // Tự động tạo slug từ name nếu chưa có
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = createSlug($data['name']);
        }

        return $this->create($data);
    }

    /**
     * Cập nhật brand
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateBrand($id, $data)
    {
        // Tự động tạo slug từ name nếu chưa có
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = createSlug($data['name']);
        }

        return $this->update($id, $data);
    }

    /**
     * Lấy tất cả brands với số lượng sản phẩm
     * @return array
     */
    public function getAllWithProductCount()
    {
        $sql = "SELECT b.*, COUNT(p.id) as product_count 
                FROM {$this->table} b
                LEFT JOIN products p ON b.id = p.brand_id
                GROUP BY b.id
                ORDER BY b.name ASC";

        return $this->query($sql);
    }

    /**
     * Xóa brand (kiểm tra có sản phẩm không)
     * @param int $id
     * @return bool
     */
    public function deleteBrand($id)
    {
        // Kiểm tra xem brand có sản phẩm không
        $sql = "SELECT COUNT(*) as total FROM products WHERE brand_id = ?";
        $result = $this->queryOne($sql, [$id]);

        if ($result['total'] > 0) {
            return false; // Không thể xóa brand có sản phẩm
        }

        return $this->delete($id);
    }
}
