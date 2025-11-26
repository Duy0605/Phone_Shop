<?php

namespace Controllers\Admin;

use Middleware\AdminMiddleware;
use Models\Product;
use Models\Brand;

/**
 * Admin ProductController
 * Quản lý sản phẩm
 */
class ProductController
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index()
    {
        AdminMiddleware::check();

        $productModel = new Product();

        // Pagination
        $page = max(1, (int) get('page', 1));
        $perPage = config('app.pagination.per_page_admin', 20);

        // Filters
        $filters = [];
        $search = get('search');
        $brandId = get('brand');

        if ($search) {
            $filters['search'] = $search;
        }

        if ($brandId) {
            $filters['brand_id'] = $brandId;
        }

        $total = $productModel->countProducts($filters);
        $pagination = paginate($total, $perPage, $page);

        // Lấy products
        $products = $productModel->getAllWithBrand(
            $filters,
            'created_at',
            'DESC',
            $perPage,
            $pagination['offset']
        );

        // Lấy brands cho filter
        $brandModel = new Brand();
        $brands = $brandModel->all('name', 'ASC');

        $pageTitle = 'Quản lý sản phẩm - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/products/index.php';
    }

    /**
     * Hiển thị form tạo sản phẩm
     */
    public function create()
    {
        AdminMiddleware::check();

        $brandModel = new Brand();
        $brands = $brandModel->all('name', 'ASC');

        $pageTitle = 'Thêm sản phẩm mới - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/products/create.php';
    }

    /**
     * Lưu sản phẩm mới
     */
    public function store()
    {
        AdminMiddleware::check();

        if (!isMethod('POST')) {
            redirect('/admin/products/create');
        }

        $name = post('name');
        $brandId = post('brand_id');
        $description = post('description');
        $specs = post('specs');
        $price = post('price');
        $stock = post('stock');

        // Validate
        $errors = [];

        if (!validateRequired($name)) {
            $errors[] = 'Vui lòng nhập tên sản phẩm';
        }

        if (!validateRequired($brandId)) {
            $errors[] = 'Vui lòng chọn thương hiệu';
        }

        if (!validatePrice($price)) {
            $errors[] = 'Giá không hợp lệ';
        }

        if (!validateQuantity($stock)) {
            $errors[] = 'Số lượng không hợp lệ';
        }

        // Upload image
        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            $uploadResult = uploadFile($_FILES['image'], 'uploads/products');

            if ($uploadResult['success']) {
                $imagePath = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['message'];
            }
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/admin/products/create');
        }

        // Tạo product
        $productModel = new Product();
        $productId = $productModel->createProduct([
            'brand_id' => $brandId,
            'name' => $name,
            'description' => $description,
            'specs' => $specs,
            'price' => $price,
            'stock' => $stock,
            'image' => $imagePath
        ]);

        if ($productId) {
            setFlashMessage('success', 'Thêm sản phẩm thành công!');
            redirect('/admin/products');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
            redirect('/admin/products/create');
        }
    }

    /**
     * Hiển thị form sửa sản phẩm
     */
    public function edit($id)
    {
        AdminMiddleware::check();

        $productModel = new Product();
        $product = $productModel->findWithBrand($id);

        if (!$product) {
            setFlashMessage('error', 'Sản phẩm không tồn tại!');
            redirect('/admin/products');
        }

        $brandModel = new Brand();
        $brands = $brandModel->all('name', 'ASC');

        $pageTitle = 'Sửa sản phẩm - Admin';
        require_once __DIR__ . '/../../../resources/view/admin/products/edit.php';
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update($id)
    {
        AdminMiddleware::check();

        if (!isMethod('POST')) {
            redirect('/admin/products/edit/' . $id);
        }

        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            setFlashMessage('error', 'Sản phẩm không tồn tại!');
            redirect('/admin/products');
        }

        $name = post('name');
        $brandId = post('brand_id');
        $description = post('description');
        $specs = post('specs');
        $price = post('price');
        $stock = post('stock');

        // Validate
        $errors = [];

        if (!validateRequired($name)) {
            $errors[] = 'Vui lòng nhập tên sản phẩm';
        }

        if (!validateRequired($brandId)) {
            $errors[] = 'Vui lòng chọn thương hiệu';
        }

        if (!validatePrice($price)) {
            $errors[] = 'Giá không hợp lệ';
        }

        if (!validateQuantity($stock)) {
            $errors[] = 'Số lượng không hợp lệ';
        }

        // Upload image nếu có
        $imagePath = $product['image'];
        if (!empty($_FILES['image']['name'])) {
            $uploadResult = uploadFile($_FILES['image'], 'uploads/products');

            if ($uploadResult['success']) {
                // Xóa ảnh cũ
                if ($product['image']) {
                    deleteFile($product['image']);
                }
                $imagePath = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['message'];
            }
        }

        if (!empty($errors)) {
            setFlashMessage('error', implode('<br>', $errors));
            redirect('/admin/products/edit/' . $id);
        }

        // Cập nhật
        $updated = $productModel->updateProduct($id, [
            'brand_id' => $brandId,
            'name' => $name,
            'description' => $description,
            'specs' => $specs,
            'price' => $price,
            'stock' => $stock,
            'image' => $imagePath
        ]);

        if ($updated) {
            setFlashMessage('success', 'Cập nhật sản phẩm thành công!');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
        }

        redirect('/admin/products');
    }

    /**
     * Xóa sản phẩm
     */
    public function delete($id)
    {
        AdminMiddleware::check();

        if (!isMethod('POST')) {
            redirect('/admin/products');
        }

        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            setFlashMessage('error', 'Sản phẩm không tồn tại!');
            redirect('/admin/products');
        }

        // Xóa ảnh
        if ($product['image']) {
            deleteFile($product['image']);
        }

        // Xóa product
        $deleted = $productModel->delete($id);

        if ($deleted) {
            setFlashMessage('success', 'Xóa sản phẩm thành công!');
        } else {
            setFlashMessage('error', 'Có lỗi xảy ra!');
        }

        redirect('/admin/products');
    }
}
