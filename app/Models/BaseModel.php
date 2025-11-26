<?php

namespace Models;

use PDO;
use PDOException;

/**
 * BaseModel
 * Class cơ sở cho tất cả các Model
 * Cung cấp kết nối database và các method CRUD cơ bản
 */
class BaseModel
{
    protected static $connection = null;
    protected $table = '';
    protected $primaryKey = 'id';

    /**
     * Khởi tạo kết nối database
     * Sử dụng PDO với Prepared Statements để bảo mật
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                $dbConfig = config('database');

                $dsn = sprintf(
                    "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                    $dbConfig['host'],
                    $dbConfig['port'] ?? 3306,
                    $dbConfig['database'],
                    $dbConfig['charset']
                );

                self::$connection = new PDO(
                    $dsn,
                    $dbConfig['username'],
                    $dbConfig['password'],
                    $dbConfig['options']
                );

            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    /**
     * Tìm 1 bản ghi theo ID
     * @param int $id
     * @return array|false
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    /**
     * Lấy tất cả bản ghi
     * @param string $orderBy
     * @param string $order
     * @return array
     */
    public function all($orderBy = null, $order = 'ASC')
    {
        $sql = "SELECT * FROM {$this->table}";

        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy} {$order}";
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Tìm theo điều kiện
     * @param array $conditions ['column' => 'value']
     * @return array
     */
    public function where($conditions = [])
    {
        $sql = "SELECT * FROM {$this->table}";

        if (!empty($conditions)) {
            $where = [];
            $params = [];

            foreach ($conditions as $column => $value) {
                $where[] = "{$column} = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * Tìm 1 bản ghi theo điều kiện
     * @param array $conditions
     * @return array|false
     */
    public function findBy($conditions = [])
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if (!empty($conditions)) {
            $where = [];

            foreach ($conditions as $column => $value) {
                $where[] = "{$column} = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $sql .= " LIMIT 1";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    /**
     * Thêm bản ghi mới
     * @param array $data
     * @return int|false Last insert ID hoặc false
     */
    public function create($data)
    {
        $columns = array_keys($data);
        $values = array_values($data);

        $placeholders = array_fill(0, count($columns), '?');

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $stmt = $this->getConnection()->prepare($sql);

        if ($stmt->execute($values)) {
            return $this->getConnection()->lastInsertId();
        }

        return false;
    }

    /**
     * Cập nhật bản ghi
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        $set = [];
        $values = [];

        foreach ($data as $column => $value) {
            $set[] = "{$column} = ?";
            $values[] = $value;
        }

        $values[] = $id;

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = ?",
            $this->table,
            implode(', ', $set),
            $this->primaryKey
        );

        $stmt = $this->getConnection()->prepare($sql);

        return $stmt->execute($values);
    }

    /**
     * Xóa bản ghi
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->getConnection()->prepare($sql);

        return $stmt->execute([$id]);
    }

    /**
     * Đếm số bản ghi
     * @param array $conditions
     * @return int
     */
    public function count($conditions = [])
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];

        if (!empty($conditions)) {
            $where = [];

            foreach ($conditions as $column => $value) {
                $where[] = "{$column} = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Thực thi câu truy vấn SQL tùy chỉnh
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * Thực thi câu truy vấn SQL và trả về 1 bản ghi
     * @param string $sql
     * @param array $params
     * @return array|false
     */
    public function queryOne($sql, $params = [])
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    /**
     * Bắt đầu transaction
     */
    public function beginTransaction()
    {
        return $this->getConnection()->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        return $this->getConnection()->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        return $this->getConnection()->rollBack();
    }
}
