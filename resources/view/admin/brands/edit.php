<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Sửa thương hiệu' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.5rem;
        }

        .nav-menu {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 0;
        }

        .nav-menu a {
            color: #667eea;
            text-decoration: none;
            margin-right: 2rem;
            font-weight: 500;
        }

        .nav-menu a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-header h2 {
            color: #333;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-group label .required {
            color: #dc3545;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input[type="file"] {
            padding: 0.5rem;
        }

        .form-group small {
            display: block;
            margin-top: 0.3rem;
            color: #666;
            font-size: 0.85rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f0f0f0;
        }

        .btn {
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .alert-error {
            background: #f8d7da;
            color: #842029;
        }

        .current-logo {
            margin-top: 0.5rem;
            max-width: 200px;
        }

        .current-logo img {
            width: 100%;
            border-radius: 6px;
            border: 2px solid #ddd;
            padding: 0.5rem;
            background: #f8f9fa;
        }

        .logo-preview {
            margin-top: 1rem;
            max-width: 200px;
            display: none;
        }

        .logo-preview img {
            width: 100%;
            border-radius: 6px;
            border: 2px solid #667eea;
            padding: 0.5rem;
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>✏️ Sửa thương hiệu - Phone Shop</h1>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span>👤 <?= escape(getUserName() ?? 'Admin') ?></span>
            <a href="<?= config('app.base_url') ?>/admin/logout" style="color: white; text-decoration: none;">Đăng
                xuất</a>
        </div>
    </div>

    <div class="nav-menu">
        <a href="<?= config('app.base_url') ?>/admin/dashboard">Dashboard</a>
        <a href="<?= config('app.base_url') ?>/admin/products">Sản phẩm</a>
        <a href="<?= config('app.base_url') ?>/admin/brands" style="color: #764ba2; font-weight: 600;">Thương hiệu</a>
        <a href="<?= config('app.base_url') ?>/admin/orders">Đơn hàng</a>
        <a href="<?= config('app.base_url') ?>/admin/customers">Khách hàng</a>
    </div>

    <div class="container">
        <?php
        $flash = getFlashMessage();
        if ($flash):
            ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <?= nl2br($flash['message']) ?>
            </div>
        <?php endif; ?>

        <div class="section">
            <div class="section-header">
                <h2>📝 Chỉnh sửa: <?= escape($brand['name']) ?></h2>
                <a href="<?= config('app.base_url') ?>/admin/brands" class="btn btn-secondary"
                    style="padding: 0.6rem 1.5rem;">
                    ← Quay lại
                </a>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>
                        Tên thương hiệu <span class="required">*</span>
                    </label>
                    <input type="text" name="name" value="<?= escape($brand['name']) ?>"
                        placeholder="VD: Apple, Samsung, Xiaomi..." required autofocus>
                    <small>Nhập tên thương hiệu chính xác</small>
                </div>

                <div class="form-group">
                    <label>Mô tả thương hiệu</label>
                    <textarea name="description"
                        placeholder="Giới thiệu ngắn gọn về thương hiệu..."><?= escape($brand['description'] ?? '') ?></textarea>
                    <small>Mô tả về lịch sử, đặc điểm, ưu điểm của thương hiệu</small>
                </div>

                <div class="form-group">
                    <label>Logo thương hiệu</label>

                    <?php if ($brand['logo']): ?>
                        <div class="current-logo">
                            <p style="margin-bottom: 0.5rem; font-weight: 500;">Logo hiện tại:</p>
                            <img src="<?= config('app.base_url') ?>/<?= escape($brand['logo']) ?>" alt="<?= escape($brand['name']) ?>">
                        </div>
                    <?php endif; ?>

                    <input type="file" name="logo" accept="image/*" id="logoInput" style="margin-top: 1rem;">
                    <small>Chọn logo mới nếu muốn thay đổi (JPG, PNG) - Tối đa 2MB. Nên dùng ảnh nền trắng/trong
                        suốt</small>

                    <div class="logo-preview" id="logoPreview">
                        <p style="margin-bottom: 0.5rem; font-weight: 500;">Logo mới:</p>
                        <img src="" alt="Preview">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        ✅ Cập nhật thương hiệu
                    </button>
                    <a href="<?= config('app.base_url') ?>/admin/brands" class="btn btn-secondary">
                        ❌ Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview logo
        document.getElementById('logoInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('logoPreview');
                    preview.querySelector('img').src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>