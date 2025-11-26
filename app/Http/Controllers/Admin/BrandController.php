<?php

namespace Controllers\Admin;

use Middleware\AdminMiddleware;
use Models\Brand;

/**
 * Admin BrandController
 * Quản lý thương hiệu
 */
class BrandController
{
    /**
     * Hiển thị danh sách brands
     */
    public function index()
    {
        AdminMiddleware::check();

        $brandModel = new Brand();

        // Lấy brands với số lượng sản phẩm
        $brands = $brandModel->getAllWithProductCount();

        $pageTitle = 'Quản lý thương hiệu - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/brands/index.php';
    }

    /**
     * Hiển thị form tạo brand
     */
    public function create()
    {
        AdminMiddleware::check();

        $pageTitle = 'Thêm thương hiệu - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/brands/create.php';
    }

    /**
     * Lưu brand mới
     */
    public function store()
    {
        AdminMiddleware::check();

        if (!isMethod('POST')) {
            redirect('/admin/brands/create');
        }

        $name = post('name');
        $description = post('description');

        // Validate
        $errors = [];

        if (!validateRequired($name)) {
            $errors[] = 'Vui lòng nhập tên thương hiệu';
        }

        // Upload logo
        $logoPath = '';
        if (!empty($_FILES['logo']['name'])) {
            $uploadResult = uploadFile($_FILES['logo'], 'uploads/brands');

            if ($uploadResult['success']) {
                $logoPath = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['message'];
            }
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/admin/brands/create');
        }

        // Tạo brand
        $brandModel = new Brand();
        $brandId = $brandModel->createBrand([
            'name' => $name,
            'description' => $description,
            'logo' => $logoPath
        ]);

        if ($brandId) {
            setFlashMessage('success', 'Thêm thương hiệu thành công!');
            redirect('/admin/brands');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
            redirect('/admin/brands/create');
        }
    }

    /**
     * Hiển thị form sửa brand
     */
    public function edit($id)
    {
        AdminMiddleware::check();

        $brandModel = new Brand();
        $brand = $brandModel->find($id);

        if (!$brand) {
            setFlashMessage('error', 'Thương hiệu không tồn tại!');
            redirect('/admin/brands');
        }

        $pageTitle = 'Sửa thương hiệu - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/brands/edit.php';
    }

    /**
     * Cập nhật brand
     */
    public function update($id)
    {
        AdminMiddleware::check();

        if (!isMethod('POST')) {
            redirect('/admin/brands/edit/' . $id);
        }

        $brandModel = new Brand();
        $brand = $brandModel->find($id);

        if (!$brand) {
            setFlashMessage('error', 'Thương hiệu không tồn tại!');
            redirect('/admin/brands');
        }

        $name = post('name');
        $description = post('description');

        // Validate
        $errors = [];

        if (!validateRequired($name)) {
            $errors[] = 'Vui lòng nhập tên thương hiệu';
        }

        // Upload logo nếu có
        $logoPath = $brand['logo'];
        if (!empty($_FILES['logo']['name'])) {
            $uploadResult = uploadFile($_FILES['logo'], 'uploads/brands');

            if ($uploadResult['success']) {
                // Xóa logo cũ
                if ($brand['logo']) {
                    deleteFile($brand['logo']);
                }
                $logoPath = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['message'];
            }
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/admin/brands/edit/' . $id);
        }

        // Cập nhật
        $updated = $brandModel->updateBrand($id, [
            'name' => $name,
            'description' => $description,
            'logo' => $logoPath
        ]);

        if ($updated) {
            setFlashMessage('success', 'Cập nhật thương hiệu thành công!');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
        }

        redirect('/admin/brands');
    }

    /**
     * Xóa brand
     */
    public function delete($id)
    {
        AdminMiddleware::check();

        if (!isMethod('POST')) {
            redirect('/admin/brands');
        }

        $brandModel = new Brand();
        $brand = $brandModel->find($id);

        if (!$brand) {
            setFlashMessage('error', 'Thương hiệu không tồn tại!');
            redirect('/admin/brands');
        }

        // Xóa brand (sẽ fail nếu có sản phẩm)
        $deleted = $brandModel->deleteBrand($id);

        if ($deleted) {
            // Xóa logo
            if ($brand['logo']) {
                deleteFile($brand['logo']);
            }

            setFlashMessage('success', 'Xóa thương hiệu thành công!');
        } else {
            setFlashMessage('error', 'Không thể xóa thương hiệu có sản phẩm!');
        }

        redirect('/admin/brands');
    }
}
