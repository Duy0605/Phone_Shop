<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Phone Shop' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .success-message {
            background: #4CAF50;
            color: white;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            margin: 2rem 0;
        }

        .success-message h2 {
            margin-bottom: 1rem;
        }

        .info-box {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .info-box h3 {
            color: #667eea;
            margin-bottom: 1rem;
        }

        .info-box ul {
            margin-left: 1.5rem;
            margin-top: 0.5rem;
        }

        .info-box li {
            margin-bottom: 0.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 0.5rem;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #5568d3;
        }

        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>🛒 Phone Shop</h1>
        <p>Website Bán Điện Thoại</p>
    </div>

    <div class="container">
        <div class="success-message">
            <h2>✅ Dự án đã chạy thành công!</h2>
            <p>Entry point và routing đã hoạt động. Bạn đang xem trang chủ.</p>
        </div>

        <div class="info-box">
            <h3>📋 Các bước tiếp theo:</h3>
            <ul>
                <li><strong>Import Database:</strong> Chạy file <code>database/schema.sql</code> và
                    <code>database/seed.sql</code> trong phpMyAdmin</li>
                <li><strong>Kiểm tra kết nối:</strong> Đảm bảo MySQL đang chạy trong XAMPP</li>
                <li><strong>Tạo views:</strong> Tạo các file view trong thư mục <code>resources/view/</code></li>
                <li><strong>Upload ảnh:</strong> Tạo thư mục <code>public/uploads/images/</code> để lưu hình ảnh sản
                    phẩm</li>
            </ul>
        </div>

        <div class="info-box">
            <h3>🔗 Các trang có sẵn:</h3>
            <p><strong>Khách hàng:</strong></p>
            <ul>
                <li><a href="<?= config('app.base_url') ?>/" class="btn">Trang chủ</a></li>
                <li><a href="<?= config('app.base_url') ?>/products" class="btn">Sản phẩm</a></li>
                <li><a href="<?= config('app.base_url') ?>/login" class="btn">Đăng nhập</a></li>
                <li><a href="<?= config('app.base_url') ?>/register" class="btn">Đăng ký</a></li>
            </ul>

            <p><strong>Quản trị:</strong></p>
            <ul>
                <li><a href="<?= config('app.base_url') ?>/admin/login" class="btn">Admin Login</a></li>
                <li><a href="<?= config('app.base_url') ?>/admin/dashboard" class="btn">Dashboard</a></li>
            </ul>
        </div>

        <div class="info-box">
            <h3>⚙️ Thông tin cấu hình:</h3>
            <ul>
                <li><strong>Base URL:</strong> <?= config('app.base_url') ?></li>
                <li><strong>Database:</strong> <?= config('database.database') ?></li>
                <li><strong>Debug Mode:</strong> <?= config('app.debug') ? 'Bật' : 'Tắt' ?></li>
                <li><strong>PHP Version:</strong> <?= phpversion() ?></li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Phone Shop. All rights reserved.</p>
    </div>
</body>

</html>