<?php
/**
 * Web Routes
 * Định nghĩa tất cả các routes cho ứng dụng
 */

// ============================================
// CUSTOMER ROUTES (Public & Authenticated)
// ============================================

// Trang chủ
$routes['GET']['/'] = 'HomeController@index';
$routes['GET']['/home'] = 'HomeController@index';

// Sản phẩm
$routes['GET']['/products'] = 'ProductController@index';
$routes['GET']['/product/{slug}'] = 'ProductController@detail';
$routes['GET']['/products/brand/{slug}'] = 'ProductController@byBrand';
$routes['GET']['/products/search'] = 'ProductController@search';

// Xác thực
$routes['GET']['/login'] = 'AuthController@showLogin';
$routes['POST']['/login'] = 'AuthController@login';
$routes['GET']['/register'] = 'AuthController@showRegister';
$routes['POST']['/register'] = 'AuthController@register';
$routes['GET']['/logout'] = 'AuthController@logout';

// Giỏ hàng (cho phép guest)
$routes['GET']['/cart'] = 'CartController@index';
$routes['POST']['/cart/add'] = 'CartController@add';
$routes['POST']['/cart/update'] = 'CartController@update';
$routes['POST']['/cart/remove'] = 'CartController@remove';
$routes['POST']['/cart/clear'] = 'CartController@clear';

// Checkout & Orders (yêu cầu đăng nhập)
$routes['GET']['/checkout'] = 'OrderController@showCheckout';
$routes['POST']['/checkout'] = 'OrderController@processCheckout';
$routes['GET']['/orders'] = 'OrderController@myOrders';
$routes['GET']['/order/{id}'] = 'OrderController@detail';
$routes['GET']['/orders/{id}'] = 'OrderController@detail'; // Alternative route

// Profile (yêu cầu đăng nhập)
$routes['GET']['/profile'] = 'AuthController@profile';
$routes['POST']['/profile/update'] = 'AuthController@updateProfile';
$routes['GET']['/profile/change-password'] = 'AuthController@showChangePassword';
$routes['POST']['/profile/change-password'] = 'AuthController@changePassword';

// ============================================
// ADMIN ROUTES (Yêu cầu quyền admin)
// ============================================

// Admin Login
$routes['GET']['/admin/login'] = 'Admin\AuthController@showLogin';
$routes['POST']['/admin/login'] = 'Admin\AuthController@login';
$routes['GET']['/admin/logout'] = 'Admin\AuthController@logout';

// Admin Dashboard
$routes['GET']['/admin'] = 'Admin\DashboardController@index';
$routes['GET']['/admin/dashboard'] = 'Admin\DashboardController@index';

// Admin - Products
$routes['GET']['/admin/products'] = 'Admin\ProductController@index';
$routes['GET']['/admin/products/create'] = 'Admin\ProductController@create';
$routes['POST']['/admin/products/create'] = 'Admin\ProductController@store';
$routes['GET']['/admin/products/edit/{id}'] = 'Admin\ProductController@edit';
$routes['POST']['/admin/products/edit/{id}'] = 'Admin\ProductController@update';
$routes['POST']['/admin/products/delete/{id}'] = 'Admin\ProductController@delete';

// Admin - Brands
$routes['GET']['/admin/brands'] = 'Admin\BrandController@index';
$routes['GET']['/admin/brands/create'] = 'Admin\BrandController@create';
$routes['POST']['/admin/brands/create'] = 'Admin\BrandController@store';
$routes['GET']['/admin/brands/edit/{id}'] = 'Admin\BrandController@edit';
$routes['POST']['/admin/brands/edit/{id}'] = 'Admin\BrandController@update';
$routes['POST']['/admin/brands/delete/{id}'] = 'Admin\BrandController@delete';

// Admin - Orders
$routes['GET']['/admin/orders'] = 'Admin\OrderController@index';
$routes['GET']['/admin/orders/{id}'] = 'Admin\OrderController@detail';
$routes['POST']['/admin/orders/{id}/status'] = 'Admin\OrderController@updateStatus';
$routes['POST']['/admin/orders/{id}/cancel'] = 'Admin\OrderController@cancel';

// Admin - Customers
$routes['GET']['/admin/customers'] = 'Admin\CustomerController@index';
$routes['GET']['/admin/customers/{id}'] = 'Admin\CustomerController@detail';

// ============================================
// API ROUTES (AJAX endpoints)
// ============================================

// Cart API (trả về JSON)
$routes['POST']['/api/cart/add'] = 'Api\CartController@add';
$routes['POST']['/api/cart/update'] = 'Api\CartController@update';
$routes['POST']['/api/cart/remove'] = 'Api\CartController@remove';
$routes['GET']['/api/cart/count'] = 'Api\CartController@count';

// Return routes array
return $routes;
