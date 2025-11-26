<?php

namespace Controllers;

use Models\Product;
use Models\Brand;

/**
 * HomeController
 * Xử lý trang chủ
 */
class HomeController
{
    /**
     * Hiển thị trang chủ
     */
    public function index()
    {
        $productModel = new Product();
        $brandModel = new Brand();

        // Lấy sản phẩm mới nhất
        $latestProducts = $productModel->getLatest(12);

        // Lấy sản phẩm nổi bật
        $featuredProducts = $productModel->getFeatured(8);

        // Lấy tất cả brands
        $brands = $brandModel->all('name', 'ASC');

        // Load view
        $pageTitle = 'Trang chủ - Phone Shop';
        require_once __DIR__ . '/../../../resources/view/home.php';
    }
}
