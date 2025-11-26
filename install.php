<?php
/**
 * Installation Script
 * Script tự động cài đặt database cho dự án Phone Shop
 */

// Cấu hình database
$dbHost = 'localhost';
$dbPort = 3307;
$dbUser = 'root';
$dbPass = '';
$dbName = 'phone_shop';

// Đường dẫn file SQL
$schemaFile = __DIR__ . '/database/schema.sql';
$seedFile = __DIR__ . '/database/seed.sql';

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt Phone Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .container {
            background: white;
            max-width: 600px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: #667eea;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .header h1 {
            margin-bottom: 0.5rem;
        }

        .content {
            padding: 2rem;
        }

        .step {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-left: 4px solid #667eea;
            background: #f8f9fa;
        }

        .step h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .success {
            border-left-color: #4CAF50;
            background: #e8f5e9;
        }

        .success h3 {
            color: #4CAF50;
        }

        .error {
            border-left-color: #f44336;
            background: #ffebee;
        }

        .error h3 {
            color: #f44336;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #5568d3;
        }

        .btn-success {
            background: #4CAF50;
        }

        .btn-success:hover {
            background: #45a049;
        }

        pre {
            background: #f5f5f5;
            padding: 1rem;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Phone Shop</h1>
            <p>Cài đặt Database</p>
        </div>

        <div class="content">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install'])) {
                // Bắt đầu cài đặt
                echo '<div class="step"><h3>📦 Đang cài đặt...</h3></div>';

                try {
                    // Kết nối MySQL (không chọn database)
                    $conn = new mysqli($dbHost, $dbUser, $dbPass, '', $dbPort);

                    if ($conn->connect_error) {
                        throw new Exception("Không thể kết nối MySQL: " . $conn->connect_error);
                    }

                    echo '<div class="step success"><h3>✅ Bước 1: Kết nối MySQL thành công</h3></div>';

                    // Đọc và thực thi schema.sql
                    if (!file_exists($schemaFile)) {
                        throw new Exception("Không tìm thấy file schema.sql");
                    }

                    $schemaSql = file_get_contents($schemaFile);

                    // Tách các câu lệnh SQL
                    $statements = array_filter(array_map('trim', explode(';', $schemaSql)));

                    foreach ($statements as $statement) {
                        if (!empty($statement) && !preg_match('/^--/', $statement)) {
                            if (!$conn->multi_query($statement)) {
                                // Lấy kết quả nếu có
                                while ($conn->more_results() && $conn->next_result())
                                    ;
                            }
                        }
                    }

                    // Đợi tất cả queries hoàn thành
                    while ($conn->more_results() && $conn->next_result())
                        ;

                    echo '<div class="step success"><h3>✅ Bước 2: Tạo database và tables thành công</h3></div>';

                    // Chọn database
                    $conn->select_db($dbName);

                    // Đọc và thực thi seed.sql
                    if (file_exists($seedFile)) {
                        $seedSql = file_get_contents($seedFile);
                        $statements = array_filter(array_map('trim', explode(';', $seedSql)));

                        foreach ($statements as $statement) {
                            if (!empty($statement) && !preg_match('/^--/', $statement)) {
                                if (!$conn->multi_query($statement)) {
                                    while ($conn->more_results() && $conn->next_result())
                                        ;
                                }
                            }
                        }

                        while ($conn->more_results() && $conn->next_result())
                            ;

                        echo '<div class="step success"><h3>✅ Bước 3: Import dữ liệu mẫu thành công</h3></div>';
                    }

                    $conn->close();

                    echo '<div class="step success">
                        <h3>🎉 Cài đặt hoàn tất!</h3>
                        <p><strong>Thông tin đăng nhập Admin:</strong></p>
                        <pre>Email: admin@phoneshop.com
Password: 123456</pre>
                        <p style="margin-top: 1rem;">
                            <a href="public/index.php" class="btn btn-success">Vào Trang Chủ</a>
                            <a href="public/index.php?redirect=admin" class="btn">Vào Admin Panel</a>
                        </p>
                    </div>';

                } catch (Exception $e) {
                    echo '<div class="step error">
                        <h3>❌ Lỗi: ' . $e->getMessage() . '</h3>
                        <p>Vui lòng kiểm tra:</p>
                        <ul>
                            <li>XAMPP đã bật MySQL chưa?</li>
                            <li>Thông tin kết nối database có đúng không?</li>
                            <li>File schema.sql và seed.sql có tồn tại không?</li>
                        </ul>
                    </div>';
                }

            } else {
                // Hiển thị form cài đặt
                ?>
                <div class="step">
                    <h3>📋 Hướng dẫn cài đặt</h3>
                    <ol>
                        <li>Đảm bảo XAMPP đã khởi động <strong>Apache</strong> và <strong>MySQL</strong></li>
                        <li>Click nút "Cài đặt" bên dưới</li>
                        <li>Chờ quá trình cài đặt hoàn tất</li>
                        <li>Đăng nhập với tài khoản admin mặc định</li>
                    </ol>
                </div>

                <div class="step">
                    <h3>⚙️ Cấu hình Database</h3>
                    <pre>Host: <?= $dbHost ?>
        Database: <?= $dbName ?>
        User: <?= $dbUser ?>
        Password: <?= empty($dbPass) ? '(trống)' : $dbPass ?></pre>
                </div>

                <div class="step">
                    <h3>📁 Files cần thiết</h3>
                    <ul>
                        <li><?= file_exists($schemaFile) ? '✅' : '❌' ?> schema.sql</li>
                        <li><?= file_exists($seedFile) ? '✅' : '❌' ?> seed.sql</li>
                    </ul>
                </div>

                <form method="POST" style="text-align: center; margin-top: 2rem;">
                    <button type="submit" name="install" class="btn">🚀 Bắt đầu cài đặt</button>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
</body>

</html>