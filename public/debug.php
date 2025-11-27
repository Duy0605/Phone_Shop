<?php
/**
 * Debug File - Kiểm tra cấu hình
 * Chạy file này để kiểm tra cấu hình trên máy mới
 * URL: http://localhost/your-path/public/debug.php
 */

session_start();

// Require autoloader
require_once __DIR__ . '/../autoload.php';

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Phone Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }

        h2 {
            color: #667eea;
            margin: 30px 0 15px;
            font-size: 1.3rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #f0f0f0;
        }

        .status-ok {
            color: #10b981;
            font-weight: bold;
        }

        .status-warning {
            color: #f59e0b;
            font-weight: bold;
        }

        .status-error {
            color: #ef4444;
            font-weight: bold;
        }

        .code {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }

        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid;
        }

        .alert-success {
            background: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        .alert-warning {
            background: #fef3c7;
            border-color: #f59e0b;
            color: #92400e;
        }

        .alert-info {
            background: #dbeafe;
            border-color: #3b82f6;
            color: #1e3a8a;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🔍 Phone Shop - Debug Information</h1>

        <div class="alert alert-info">
            <strong>Mục đích:</strong> File này giúp kiểm tra cấu hình và debug khi dự án không chạy đúng trên máy mới.
        </div>

        <h2>📋 Thông tin Server</h2>
        <table>
            <tr>
                <th width="30%">Tham số</th>
                <th>Giá trị</th>
            </tr>
            <tr>
                <td><strong>SERVER_NAME</strong></td>
                <td><?= $_SERVER['SERVER_NAME'] ?? 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>HTTP_HOST</strong></td>
                <td><?= $_SERVER['HTTP_HOST'] ?? 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>SERVER_PORT</strong></td>
                <td><?= $_SERVER['SERVER_PORT'] ?? 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>DOCUMENT_ROOT</strong></td>
                <td><?= $_SERVER['DOCUMENT_ROOT'] ?? 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>SCRIPT_NAME</strong></td>
                <td><?= $_SERVER['SCRIPT_NAME'] ?? 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>SCRIPT_FILENAME</strong></td>
                <td><?= $_SERVER['SCRIPT_FILENAME'] ?? 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>REQUEST_URI</strong></td>
                <td><?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>PHP Version</strong></td>
                <td><?= phpversion() ?></td>
            </tr>
        </table>

        <h2>🔗 URL Configuration</h2>
        <?php
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = str_replace('\\', '/', dirname($scriptName));

        $autoBaseUrl = $protocol . '://' . $host . $baseDir;
        ?>
        <table>
            <tr>
                <th width="30%">Cấu hình</th>
                <th>Giá trị</th>
            </tr>
            <tr>
                <td><strong>Protocol</strong></td>
                <td><?= $protocol ?></td>
            </tr>
            <tr>
                <td><strong>Host</strong></td>
                <td><?= $host ?></td>
            </tr>
            <tr>
                <td><strong>Base Directory</strong></td>
                <td><?= $baseDir ?></td>
            </tr>
            <tr>
                <td><strong>Auto Base URL</strong></td>
                <td class="status-ok"><?= $autoBaseUrl ?></td>
            </tr>
            <tr>
                <td><strong>Config Base URL</strong></td>
                <td><?= config('app.base_url') ?></td>
            </tr>
            <tr>
                <td><strong>Match?</strong></td>
                <td class="<?= $autoBaseUrl === config('app.base_url') ? 'status-ok' : 'status-warning' ?>">
                    <?= $autoBaseUrl === config('app.base_url') ? '✓ Khớp' : '⚠ Không khớp' ?>
                </td>
            </tr>
        </table>

        <?php if ($autoBaseUrl !== config('app.base_url')): ?>
            <div class="alert alert-warning">
                <strong>⚠ Cảnh báo:</strong> Base URL tự động detect khác với config. Điều này có thể gây lỗi!
            </div>
        <?php endif; ?>

        <h2>📁 Đường dẫn thư mục</h2>
        <table>
            <tr>
                <th width="30%">Thư mục</th>
                <th>Đường dẫn</th>
                <th width="15%">Tồn tại?</th>
            </tr>
            <?php
            $paths = [
                'Root Path' => config('app.root_path'),
                'App Path' => config('app.app_path'),
                'Public Path' => config('app.public_path'),
                'Resources Path' => config('app.resources_path'),
                'Upload Path' => config('app.upload_path'),
            ];

            foreach ($paths as $name => $path) {
                $exists = is_dir($path);
                $statusClass = $exists ? 'status-ok' : 'status-error';
                echo "<tr>";
                echo "<td><strong>{$name}</strong></td>";
                echo "<td>{$path}</td>";
                echo "<td class='{$statusClass}'>" . ($exists ? '✓ Có' : '✗ Không') . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h2>💾 Database Configuration</h2>
        <table>
            <tr>
                <th width="30%">Tham số</th>
                <th>Giá trị</th>
            </tr>
            <tr>
                <td><strong>Host</strong></td>
                <td><?= config('database.host') ?></td>
            </tr>
            <tr>
                <td><strong>Port</strong></td>
                <td><?= config('database.port') ?></td>
            </tr>
            <tr>
                <td><strong>Database</strong></td>
                <td><?= config('database.database') ?></td>
            </tr>
            <tr>
                <td><strong>Username</strong></td>
                <td><?= config('database.username') ?></td>
            </tr>
            <tr>
                <td><strong>Connection</strong></td>
                <td>
                    <?php
                    try {
                        $db = new PDO(
                            "mysql:host=" . config('database.host') . ";port=" . config('database.port') . ";dbname=" . config('database.database'),
                            config('database.username'),
                            config('database.password')
                        );
                        echo '<span class="status-ok">✓ Kết nối thành công</span>';
                    } catch (PDOException $e) {
                        echo '<span class="status-error">✗ Lỗi: ' . $e->getMessage() . '</span>';
                    }
                    ?>
                </td>
            </tr>
        </table>

        <h2>🔐 Session Information</h2>
        <table>
            <tr>
                <th width="30%">Tham số</th>
                <th>Giá trị</th>
            </tr>
            <tr>
                <td><strong>Session Started</strong></td>
                <td class="<?= session_status() === PHP_SESSION_ACTIVE ? 'status-ok' : 'status-error' ?>">
                    <?= session_status() === PHP_SESSION_ACTIVE ? '✓ Có' : '✗ Không' ?>
                </td>
            </tr>
            <tr>
                <td><strong>Session ID</strong></td>
                <td><?= session_id() ?: 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>Session Name</strong></td>
                <td><?= session_name() ?></td>
            </tr>
            <tr>
                <td><strong>Logged In</strong></td>
                <td class="<?= isAuthenticated() ? 'status-ok' : 'status-warning' ?>">
                    <?= isAuthenticated() ? '✓ Đã đăng nhập' : '✗ Chưa đăng nhập' ?>
                </td>
            </tr>
            <?php if (isAuthenticated()): ?>
                <tr>
                    <td><strong>User ID</strong></td>
                    <td><?= getUserId() ?></td>
                </tr>
                <tr>
                    <td><strong>User Name</strong></td>
                    <td><?= getUserName() ?></td>
                </tr>
                <tr>
                    <td><strong>User Role</strong></td>
                    <td><?= getUserRole() ?></td>
                </tr>
            <?php endif; ?>
        </table>

        <h2>🧪 Test URLs</h2>
        <div class="alert alert-info">
            <strong>Test các link sau để kiểm tra routing:</strong>
        </div>
        <table>
            <tr>
                <th width="30%">Trang</th>
                <th>URL</th>
            </tr>
            <tr>
                <td>Trang chủ</td>
                <td><a href="<?= config('app.base_url') ?>/" target="_blank"><?= config('app.base_url') ?>/</a></td>
            </tr>
            <tr>
                <td>Đăng nhập</td>
                <td><a href="<?= config('app.base_url') ?>/login"
                        target="_blank"><?= config('app.base_url') ?>/login</a></td>
            </tr>
            <tr>
                <td>Đăng ký</td>
                <td><a href="<?= config('app.base_url') ?>/register"
                        target="_blank"><?= config('app.base_url') ?>/register</a></td>
            </tr>
            <tr>
                <td>Sản phẩm</td>
                <td><a href="<?= config('app.base_url') ?>/products"
                        target="_blank"><?= config('app.base_url') ?>/products</a></td>
            </tr>
            <tr>
                <td>Admin Login</td>
                <td><a href="<?= config('app.base_url') ?>/admin/login"
                        target="_blank"><?= config('app.base_url') ?>/admin/login</a></td>
            </tr>
        </table>

        <h2>✅ Checklist triển khai</h2>
        <div class="code">
            <strong>Khi triển khai dự án lên máy mới, làm theo các bước sau:</strong><br><br>

            1. Sao chép toàn bộ dự án vào thư mục htdocs của XAMPP<br>
            2. Tạo database mới và import file database/schema.sql<br>
            3. Import dữ liệu mẫu từ database/seed.sql (nếu có)<br>
            4. Cấu hình database trong config/database.php<br>
            5. Đảm bảo thư mục public/uploads có quyền ghi (chmod 755 hoặc 777)<br>
            6. Truy cập: http://localhost/[tên-thư-mục]/public/<br>
            7. Nếu có lỗi, chạy file debug.php này để kiểm tra<br>
            8. KHÔNG CẦN sửa port, chỉ cần đảm bảo đường dẫn đúng
        </div>

        <div class="alert alert-success">
            <strong>✓ Hoàn tất!</strong> Nếu tất cả thông tin trên đều OK, dự án sẽ hoạt động bình thường.
        </div>
    </div>
</body>

</html>