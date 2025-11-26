# Phone Shop - Website Bán Điện Thoại

Website thương mại điện tử bán điện thoại di động được xây dựng bằng PHP thuần (không framework), theo mô hình MVC.

## 🚀 Tính năng

### Khách hàng

-   ✅ Xem danh sách sản phẩm
-   ✅ Tìm kiếm và lọc sản phẩm theo thương hiệu, giá
-   ✅ Xem chi tiết sản phẩm
-   ✅ Giỏ hàng (AJAX)
-   ✅ Đăng ký/Đăng nhập
-   ✅ Đặt hàng (COD)
-   ✅ Xem lịch sử đơn hàng

### Quản trị viên

-   ✅ Dashboard thống kê
-   ✅ Quản lý sản phẩm (CRUD)
-   ✅ Quản lý thương hiệu
-   ✅ Quản lý đơn hàng
-   ✅ Quản lý khách hàng

## 🛠️ Công nghệ sử dụng

-   **Backend:** PHP 7.4+
-   **Database:** MySQL/MariaDB
-   **Frontend:** HTML5, CSS3, JavaScript (Vanilla JS)
-   **Architecture:** MVC Pattern
-   **Security:** Prepared Statements, Password Hashing, XSS Protection

## 📋 Yêu cầu hệ thống

-   PHP >= 7.4
-   MySQL >= 5.7 hoặc MariaDB >= 10.4
-   Apache với mod_rewrite
-   XAMPP/WAMP/LAMP (khuyến nghị)

## 🔧 Cài đặt

### 1. Clone repository

```bash
git clone https://github.com/your-username/phone-shop.git
cd phone-shop
```

### 2. Cấu hình database

Mở file `config/database.php` và cập nhật thông tin:

```php
return [
    'host' => 'localhost',
    'port' => 3307, // Thay đổi nếu cần
    'database' => 'phone_shop',
    'username' => 'root',
    'password' => '', // Thêm password nếu có
    // ...
];
```

### 3. Cấu hình base URL

Mở file `config/app.php` và cập nhật:

```php
'base_url' => 'http://localhost/phone-shop/public',
'assets_url' => 'http://localhost/phone-shop/resources',
```

### 4. Import database

**Cách 1: Sử dụng script tự động**

Truy cập: `http://localhost/phone-shop/install.php` và click "Bắt đầu cài đặt"

**Cách 2: Import thủ công**

1. Mở phpMyAdmin
2. Tạo database tên `phone_shop`
3. Import file `database/schema.sql`
4. Import file `database/seed.sql`

### 5. Tạo thư mục uploads

```bash
mkdir -p public/uploads/images
chmod 755 public/uploads/images
```

## 🎯 Sử dụng

### Truy cập website

-   **Trang khách hàng:** `http://localhost/phone-shop/public/`
-   **Trang admin:** `http://localhost/phone-shop/public/admin/login`

### Tài khoản mặc định

**Admin:**

-   Email: `admin@phoneshop.com`
-   Password: `123456`

**Khách hàng:** Đăng ký tài khoản mới

## 📁 Cấu trúc dự án

```
phone-shop/
├── app/
│   ├── Helper/           # Các hàm helper
│   ├── Http/
│   │   ├── Controllers/  # Controllers
│   │   ├── Middleware/   # Middleware
│   │   └── Kernel.php    # Route dispatcher
│   └── Models/           # Models
├── config/               # File cấu hình
├── database/             # SQL schema & seed
├── public/               # Thư mục public (entry point)
│   ├── uploads/          # Upload files
│   └── index.php         # Entry point
├── resources/            # Resources
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript
│   └── view/             # View files
├── routes/               # Route definitions
├── autoload.php          # Autoloader
└── README.md
```

## 🔒 Bảo mật

-   ✅ Password hashing với `password_hash()`
-   ✅ Prepared Statements (PDO)
-   ✅ XSS Protection với `htmlspecialchars()`
-   ✅ CSRF Token
-   ✅ Session Security

## 📝 License

MIT License

## 👥 Tác giả

Dự án được phát triển bởi [Tên của bạn]

## 📞 Liên hệ

-   Email: your-email@example.com
-   GitHub: [@your-username](https://github.com/your-username)
