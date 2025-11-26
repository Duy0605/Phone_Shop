<?php

namespace Controllers;

use Models\Product;
use Models\Brand;

/**
 * ProductController
 * Xử lý danh sách sản phẩm, chi tiết, tìm kiếm, lọc
 */
class ProductController
{
    /**
     * Hiển thị danh sách sản phẩm với phân trang
     */
    public function index()
    {
        $productModel = new Product();
        $brandModel = new Brand();

        // Lấy parameters từ URL
        $page = max(1, (int) get('page', 1));
        $brandId = get('brand');
        $minPrice = get('min_price');
        $maxPrice = get('max_price');
        $search = get('search');
        $sortBy = get('sort', 'created_at');
        $sortOrder = get('order', 'DESC');

        // Validate sort parameters
        $allowedSort = ['name', 'price', 'created_at'];
        if (!in_array($sortBy, $allowedSort)) {
            $sortBy = 'created_at';
        }

        $allowedOrder = ['ASC', 'DESC'];
        if (!in_array($sortOrder, $allowedOrder)) {
            $sortOrder = 'DESC';
        }

        // Build filters
        $filters = [
            'in_stock' => true
        ];

        if ($brandId) {
            $filters['brand_id'] = $brandId;
        }

        if ($minPrice) {
            $filters['min_price'] = $minPrice;
        }

        if ($maxPrice) {
            $filters['max_price'] = $maxPrice;
        }

        if ($search) {
            $filters['search'] = $search;
        }

        // Pagination
        $perPage = config('app.pagination.per_page', 12);
        $total = $productModel->countProducts($filters);
        $pagination = paginate($total, $perPage, $page);

        // Lấy products
        $products = $productModel->getAllWithBrand(
            $filters,
            $sortBy,
            $sortOrder,
            $perPage,
            $pagination['offset']
        );

        // Lấy brands cho filter
        $brands = $brandModel->all('name', 'ASC');

        $pageTitle = 'Danh sách sản phẩm';
        require_once __DIR__ . '/../../resources/view/products/index.php';
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function detail($slug)
    {
        $productModel = new Product();

        // Lấy sản phẩm theo slug
        $product = $productModel->findBySlugWithBrand($slug);

        if (!$product) {
            setFlashMessage('error', 'Sản phẩm không tồn tại!');
            redirect('/products');
        }

        // Parse specs từ JSON
        if (!empty($product['specs'])) {
            $product['specs'] = json_decode($product['specs'], true);
        }

        // Lấy sản phẩm cùng brand
        $relatedProducts = $productModel->getByBrand($product['brand_id'], 4);

        $pageTitle = $product['name'];
        require_once __DIR__ . '/../../resources/view/products/detail.php';
    }

    /**
     * Hiển thị sản phẩm theo brand
     */
    public function byBrand($slug)
    {
        $brandModel = new Brand();
        $productModel = new Product();

        // Tìm brand
        $brand = $brandModel->findBySlug($slug);

        if (!$brand) {
            setFlashMessage('error', 'Thương hiệu không tồn tại!');
            redirect('/products');
        }

        // Pagination
        $page = max(1, (int) get('page', 1));
        $perPage = config('app.pagination.per_page', 12);

        $filters = [
            'brand_id' => $brand['id'],
            'in_stock' => true
        ];

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

        $pageTitle = 'Sản phẩm ' . $brand['name'];
        require_once __DIR__ . '/../../resources/view/products/by-brand.php';
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search()
    {
        $keyword = get('q');

        if (!$keyword) {
            redirect('/products');
        }

        $productModel = new Product();

        // Pagination
        $page = max(1, (int) get('page', 1));
        $perPage = config('app.pagination.per_page', 12);

        $filters = [
            'search' => $keyword,
            'in_stock' => true
        ];

        $total = $productModel->countProducts($filters);
        $pagination = paginate($total, $perPage, $page);

        // Lấy products
        $products = $productModel->getAllWithBrand(
            $filters,
            'name',
            'ASC',
            $perPage,
            $pagination['offset']
        );

        $pageTitle = 'Tìm kiếm: ' . escape($keyword);
        require_once __DIR__ . '/../../resources/view/products/search.php';
    }
}
