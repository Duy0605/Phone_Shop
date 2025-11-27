<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Quản lý thương hiệu' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { font-size: 1.5rem; }
        .nav-menu {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 0;
        }
        .nav-menu a {
            color: #667eea;
            text-decoration: none;
            margin-right: 2rem;
            font-weight: 500;
        }
        .nav-menu a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .section-header h2 { color: #333; font-size: 1.5rem; }
        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover { background: #218838; }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover { background: #5568d3; }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover { background: #c82333; }
        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }
        .brands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .brand-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.3s;
            position: relative;
        }
        .brand-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }
        .brand-logo {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        .brand-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .brand-logo .placeholder {
            font-size: 3rem;
        }
        .brand-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .brand-slug {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        .brand-description {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .brand-stats {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            background: #e7f3ff;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        .brand-stats .count {
            font-weight: 600;
            color: #667eea;
        }
        .brand-actions {
            display: flex;
            gap: 0.5rem;
        }
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }
        .alert-success { background: #d1e7dd; color: #0f5132; }
        .alert-error { background: #f8d7da; color: #842029; }
        .no-data {
            text-align: center;
            padding: 3rem;
            color: #999;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        table th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }
        table td {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }
        table tr:hover { background: #f8f9fa; }
        .logo-cell {
            width: 80px;
        }
        .logo-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background: #f8f9fa;
            border-radius: 6px;
            padding: 0.3rem;
        }
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        .view-toggle {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .view-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 500;
        }
        .view-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏷️ Quản lý thương hiệu - Phone Shop</h1>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span>👤 <?= escape(getUserName() ?? 'Admin') ?></span>
            <a href="<?= config('app.base_url') ?>/admin/logout" 
               style="color: white; text-decoration: none;">Đăng xuất</a>
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
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <div class="section">
            <div class="section-header">
                <div>
                    <h2>🏷️ Danh sách thương hiệu</h2>
                    <p style="color: #666; margin-top: 0.5rem;">
                        Tổng: <strong><?= count($brands) ?></strong> thương hiệu
                    </p>
                </div>
                <a href="<?= config('app.base_url') ?>/admin/brands/create" class="btn btn-success">
                    ➕ Thêm thương hiệu
                </a>
            </div>

            <div class="view-toggle">
                <button class="view-btn active" onclick="toggleView('grid')">📱 Lưới</button>
                <button class="view-btn" onclick="toggleView('table')">📋 Bảng</button>
            </div>

            <?php if (!empty($brands)): ?>
                <!-- Grid View -->
                <div id="gridView" class="brands-grid">
                    <?php foreach ($brands as $brand): ?>
                        <div class="brand-card">
                            <div class="brand-logo">
                                <?php if ($brand['logo']): ?>
                                    <img src="<?= config('app.base_url') ?>/<?= escape($brand['logo']) ?>" 
                                         alt="<?= escape($brand['name']) ?>">
                                <?php else: ?>
                                    <div class="placeholder">🏷️</div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="brand-name"><?= escape($brand['name']) ?></div>
                            
                            <div class="brand-slug">
                                🔗 /<?= escape($brand['slug']) ?>
                            </div>
                            
                            <?php if ($brand['description']): ?>
                                <div class="brand-description">
                                    <?= escape($brand['description']) ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="brand-stats">
                                📦 <span class="count"><?= $brand['product_count'] ?></span> sản phẩm
                            </div>
                            
                            <div class="brand-actions">
                                <a href="<?= config('app.base_url') ?>/admin/brands/edit/<?= $brand['id'] ?>" 
                                   class="btn btn-primary btn-sm" style="flex: 1; text-align: center;">
                                    ✏️ Sửa
                                </a>
                                <form method="POST" 
                                      action="<?= config('app.base_url') ?>/admin/brands/delete/<?= $brand['id'] ?>"
                                      onsubmit="return confirm('<?= $brand['product_count'] > 0 ? 'Thương hiệu này có ' . $brand['product_count'] . ' sản phẩm. Không thể xóa!' : 'Bạn có chắc muốn xóa thương hiệu này?' ?>')"
                                      style="flex: 1;">
                                    <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;"
                                            <?= $brand['product_count'] > 0 ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : '' ?>>
                                        🗑️ Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Table View -->
                <div id="tableView" style="display: none;">
                    <table>
                        <thead>
                            <tr>
                                <th class="logo-cell">Logo</th>
                                <th>Tên thương hiệu</th>
                                <th>Slug</th>
                                <th>Sản phẩm</th>
                                <th>Ngày tạo</th>
                                <th style="width: 200px; text-align: center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($brands as $brand): ?>
                                <tr>
                                    <td class="logo-cell">
                                        <?php if ($brand['logo']): ?>
                                            <img src="<?= config('app.base_url') ?>/<?= escape($brand['logo']) ?>" 
                                                 alt="<?= escape($brand['name']) ?>" 
                                                 class="logo-img">
                                        <?php else: ?>
                                            <div class="logo-img" style="display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                                🏷️
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;"><?= escape($brand['name']) ?></div>
                                        <?php if ($brand['description']): ?>
                                            <div style="font-size: 0.85rem; color: #666; margin-top: 0.3rem;">
                                                <?= escape(mb_substr($brand['description'], 0, 60)) ?>...
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="color: #666; font-size: 0.9rem;">
                                        /<?= escape($brand['slug']) ?>
                                    </td>
                                    <td>
                                        <span style="background: #e7f3ff; color: #667eea; padding: 0.3rem 0.8rem; border-radius: 12px; font-weight: 600; font-size: 0.9rem;">
                                            <?= $brand['product_count'] ?> sản phẩm
                                        </span>
                                    </td>
                                    <td style="color: #666; font-size: 0.9rem;">
                                        <?= formatDateTime($brand['created_at']) ?>
                                    </td>
                                    <td>
                                        <div class="actions" style="justify-content: center;">
                                            <a href="<?= config('app.base_url') ?>/admin/brands/edit/<?= $brand['id'] ?>" 
                                               class="btn btn-primary btn-sm">
                                                ✏️ Sửa
                                            </a>
                                            <form method="POST" 
                                                  action="<?= config('app.base_url') ?>/admin/brands/delete/<?= $brand['id'] ?>"
                                                  onsubmit="return confirm('<?= $brand['product_count'] > 0 ? 'Thương hiệu này có ' . $brand['product_count'] . ' sản phẩm. Không thể xóa!' : 'Bạn có chắc muốn xóa thương hiệu này?' ?>')"
                                                  style="display: inline;">
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        <?= $brand['product_count'] > 0 ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : '' ?>>
                                                    🗑️ Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <div class="no-data">
                    <p style="font-size: 3rem; margin-bottom: 1rem;">🏷️</p>
                    <p style="font-size: 1.2rem;">Chưa có thương hiệu nào</p>
                    <p style="margin-top: 1rem;">
                        <a href="<?= config('app.base_url') ?>/admin/brands/create" class="btn btn-success">
                            Thêm thương hiệu đầu tiên
                        </a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleView(view) {
            const gridView = document.getElementById('gridView');
            const tableView = document.getElementById('tableView');
            const buttons = document.querySelectorAll('.view-btn');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            
            if (view === 'grid') {
                gridView.style.display = 'grid';
                tableView.style.display = 'none';
                buttons[0].classList.add('active');
            } else {
                gridView.style.display = 'none';
                tableView.style.display = 'block';
                buttons[1].classList.add('active');
            }
        }
    </script>
</body>
</html>
