<?php

namespace Models;

/**
 * User Model
 * Quản lý thông tin người dùng (khách hàng và admin)
 */
class User extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * Tìm user theo email
     * @param string $email
     * @return array|false
     */
    public function findByEmail($email)
    {
        return $this->findBy(['email' => $email]);
    }

    /**
     * Tìm user theo phone
     * @param string $phone
     * @return array|false
     */
    public function findByPhone($phone)
    {
        return $this->findBy(['phone' => $phone]);
    }

    /**
     * Kiểm tra email đã tồn tại chưa
     * @param string $email
     * @param int $excludeId ID cần loại trừ (dùng khi update)
     * @return bool
     */
    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'] > 0;
    }

    /**
     * Kiểm tra phone đã tồn tại chưa
     * @param string $phone
     * @param int $excludeId
     * @return bool
     */
    public function phoneExists($phone, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE phone = ?";
        $params = [$phone];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'] > 0;
    }

    /**
     * Đăng ký user mới
     * @param array $data
     * @return int|false User ID hoặc false
     */
    public function register($data)
    {
        // Hash password trước khi lưu
        if (isset($data['password'])) {
            $data['password'] = hashPassword($data['password']);
        }

        // Set role mặc định là customer
        if (!isset($data['role'])) {
            $data['role'] = 'customer';
        }

        return $this->create($data);
    }

    /**
     * Xác thực đăng nhập
     * @param string $email
     * @param string $password
     * @return array|false User data hoặc false
     */
    public function authenticate($email, $password)
    {
        $user = $this->findByEmail($email);

        if ($user && verifyPassword($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    /**
     * Cập nhật thông tin user
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateUser($id, $data)
    {
        // Không cho phép cập nhật password qua hàm này
        unset($data['password']);

        return $this->update($id, $data);
    }

    /**
     * Đổi mật khẩu
     * @param int $id
     * @param string $newPassword
     * @return bool
     */
    public function changePassword($id, $newPassword)
    {
        $hashedPassword = hashPassword($newPassword);
        return $this->update($id, ['password' => $hashedPassword]);
    }

    /**
     * Lấy tất cả customers
     * @return array
     */
    public function getAllCustomers()
    {
        return $this->where(['role' => 'customer']);
    }

    /**
     * Lấy tất cả admins
     * @return array
     */
    public function getAllAdmins()
    {
        return $this->where(['role' => 'admin']);
    }

    /**
     * Đếm số customers
     * @return int
     */
    public function countCustomers()
    {
        return $this->count(['role' => 'customer']);
    }

    /**
     * Lấy customers với phân trang
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getCustomersPaginated($limit = 20, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE role = 'customer' 
                ORDER BY created_at DESC 
                LIMIT ? OFFSET ?";

        return $this->query($sql, [$limit, $offset]);
    }
}
