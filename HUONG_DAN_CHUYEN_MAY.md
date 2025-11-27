# 📋 HƯỚNG DẪN TRIỂN KHAI DỰ ÁN LÊN MÁY MỚI

## ❗ VẤN ĐỀ ĐÃ ĐƯỢC KHẮC PHỤC

**Vấn đề ban đầu:** Khi đăng ký tài khoản trên máy khác, form bị reset và mất dữ liệu.

**Nguyên nhân:**

-   Form action dùng absolute URL với `base_url` tự động detect
-   Khi đường dẫn dự án khác nhau giữa các máy → `base_url` sai → form gửi sai địa chỉ
-   **KHÔNG PHẢI DO PORT!** Đây là vấn đề về đường dẫn base directory

**Giải pháp đã áp dụng:**

1. ✅ Đã sửa tất cả form POST để dùng relative URL (`action=""`)
2. ✅ Cải thiện hàm `redirect()` để xử lý đường dẫn chính xác hơn
3. ✅ Cải thiện xử lý URI trong Kernel để tương thích mọi cấu hình
4. ✅ Tạo file `debug.php` để kiểm tra cấu hình

---

## 🚀 CÁC BƯỚC TRIỂN KHAI

### Bước 1: Chuẩn bị môi trường

-   ✅ Cài đặt XAMPP (hoặc LAMP/MAMP/WAMP)
-   ✅ Khởi động Apache và MySQL
-   ✅ PHP >= 7.4

### Bước 2: Sao chép dự án

```
1. Copy toàn bộ thư mục dự án vào htdocs
   Ví dụ: C:\xampp\htdocs\Phone_Shop

2. Đảm bảo cấu trúc thư mục như sau:
   Phone_Shop/
   ├── app/
   ├── config/
   ├── database/
   ├── public/         ← Thư mục entry point
   ├── resources/
   └── routes/
```

### Bước 3: Tạo Database

```sql
-- Tạo database mới
CREATE DATABASE phone_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Import schema
-- Vào phpMyAdmin → chọn database phone_shop → Import → chọn file database/schema.sql

-- Import dữ liệu mẫu (optional)
-- Import file database/seed.sql
```

### Bước 4: Cấu hình Database

Mở file `config/database.php` và chỉnh sửa:

```php
return [
    'host' => 'localhost',      // Thường là localhost
    'port' => 3306,             // Port mặc định của MySQL
    'database' => 'phone_shop', // Tên database vừa tạo
    'username' => 'root',       // Username MySQL
    'password' => '',           // Password MySQL (XAMPP mặc định là rỗng)
    // ... các config khác giữ nguyên
];
```

### Bước 5: Phân quyền thư mục

```
Đảm bảo thư mục sau có quyền ghi:
- public/uploads/
- public/uploads/images/

Windows: Click chuột phải → Properties → Security → cho phép Full Control
Linux/Mac: chmod 755 public/uploads -R
```

### Bước 6: Truy cập dự án

#### 🔴 QUAN TRỌNG: Xác định đường dẫn truy cập

**Tùy vào cách bạn đặt thư mục:**

1. **Nếu dự án ở root htdocs:**

    ```
    htdocs/
    └── Phone_Shop/
        └── public/

    → Truy cập: http://localhost/Phone_Shop/public/
    ```

2. **Nếu bạn đổi tên thư mục:**

    ```
    htdocs/
    └── my-shop/
        └── public/

    → Truy cập: http://localhost/my-shop/public/
    ```

3. **Nếu dự án ở thư mục con:**

    ```
    htdocs/
    └── projects/
        └── Phone_Shop/
            └── public/

    → Truy cập: http://localhost/projects/Phone_Shop/public/
    ```

### Bước 7: Kiểm tra cấu hình (QUAN TRỌNG!)

**Trước khi sử dụng, hãy chạy file debug:**

```
http://localhost/[đường-dẫn-của-bạn]/public/debug.php
```

File này sẽ hiển thị:

-   ✅ Thông tin server và cấu hình
-   ✅ Base URL có đúng không
-   ✅ Database có kết nối được không
-   ✅ Các đường dẫn thư mục có tồn tại không
-   ✅ Session có hoạt động không

**Nếu thấy cảnh báo màu vàng/đỏ → cần sửa lại cấu hình!**

---

## 🧪 TEST CHỨC NĂNG

### 1. Test Routing

Mở các URL sau và đảm bảo không bị 404:

-   `http://localhost/[path]/public/` → Trang chủ
-   `http://localhost/[path]/public/register` → Form đăng ký
-   `http://localhost/[path]/public/login` → Form đăng nhập
-   `http://localhost/[path]/public/products` → Danh sách sản phẩm

### 2. Test Form Đăng Ký

1. Mở trang đăng ký
2. Nhập đầy đủ thông tin:
    - Họ tên: Nguyễn Văn A
    - Email: test@example.com
    - SĐT: 0912345678
    - Mật khẩu: 123456
3. Bấm "Đăng ký"
4. **Kết quả mong đợi:**
    - ✅ Chuyển sang trang login với thông báo "Đăng ký thành công"
    - ❌ KHÔNG được quay lại form trống hoặc mất dữ liệu

### 3. Test Đăng Nhập

```
Email: admin@phoneshop.com
Password: 123456
```

---

## ⚠️ XỬ LÝ LỖI THƯỜNG GẶP

### Lỗi 1: Trang trắng hoặc 500 Internal Server Error

**Nguyên nhân:** Lỗi PHP hoặc thiếu module
**Giải pháp:**

```
1. Bật display_errors trong php.ini
2. Kiểm tra Apache error log
3. Đảm bảo PHP extensions đã bật: mysqli, pdo_mysql, gd
```

### Lỗi 2: 404 Not Found trên tất cả các trang

**Nguyên nhân:** .htaccess không hoạt động
**Giải pháp:**

```
1. Kiểm tra mod_rewrite đã bật trong Apache
2. Kiểm tra file .htaccess trong thư mục public/
3. Đảm bảo AllowOverride All trong httpd.conf
```

### Lỗi 3: Form đăng ký bị reset (VẤN ĐỀ ĐÃ SỬA)

**Nguyên nhân:** Base URL không đúng
**Giải pháp:**

```
1. Chạy debug.php để kiểm tra
2. Các form đã được sửa dùng relative URL
3. Nếu vẫn lỗi, kiểm tra $_SERVER['SCRIPT_NAME']
```

### Lỗi 4: Không kết nối được database

**Nguyên nhân:** Thông tin database sai
**Giải pháp:**

```
1. Kiểm tra MySQL đã chạy chưa
2. Kiểm tra username/password trong config/database.php
3. Kiểm tra database đã tạo chưa
4. Test kết nối qua phpMyAdmin
```

### Lỗi 5: Upload ảnh không được

**Nguyên nhân:** Không có quyền ghi
**Giải pháp:**

```
1. Chmod 755 hoặc 777 cho thư mục public/uploads
2. Kiểm tra upload_max_filesize trong php.ini
3. Kiểm tra post_max_size trong php.ini
```

---

## 🔧 CONFIGURATION ADVANCED (Tùy chọn)

### Cấu hình Virtual Host (Khuyến nghị cho production)

Tạo file cấu hình trong `httpd-vhosts.conf`:

```apache
<VirtualHost *:80>
    ServerName phoneshop.local
    DocumentRoot "C:/xampp/htdocs/Phone_Shop/public"

    <Directory "C:/xampp/htdocs/Phone_Shop/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Thêm vào file `hosts`:

```
127.0.0.1    phoneshop.local
```

Sau đó truy cập: `http://phoneshop.local`

---

## 📝 NOTES

### Port không phải là vấn đề

-   ❌ **KHÔNG** cần thay đổi port
-   ❌ **KHÔNG** cần hardcode port vào config
-   ✅ Dự án tự động detect port từ `$_SERVER['HTTP_HOST']`

### Base URL được tự động detect

```php
// config/app.php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$baseDir = str_replace('\\', '/', dirname($scriptName));

$autoBaseUrl = $protocol . '://' . $host . $baseDir;
```

Điều này có nghĩa:

-   Trên máy A: `http://localhost/Phone_Shop/public`
-   Trên máy B: `http://localhost/my-shop/public`
-   Trên máy C: `http://192.168.1.100/projects/shop/public`

**TẤT CẢ ĐỀU HOẠT ĐỘNG BÌNH THƯỜNG!**

---

## ✅ CHECKLIST HOÀN THÀNH

Sau khi làm xong tất cả, check lại:

-   [ ] XAMPP đã chạy (Apache + MySQL)
-   [ ] Database đã tạo và import schema
-   [ ] Config database đã đúng
-   [ ] Truy cập được trang chủ
-   [ ] Chạy debug.php không có lỗi màu đỏ
-   [ ] Đăng ký tài khoản thành công
-   [ ] Đăng nhập được
-   [ ] Upload ảnh được (nếu test thêm)

---

## 📞 HỖ TRỢ

Nếu gặp vấn đề:

1. Chạy file `public/debug.php` và chụp màn hình
2. Check Apache error log tại: `xampp/apache/logs/error.log`
3. Check PHP error trong code bằng cách thêm:
    ```php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ```

---

**Chúc bạn triển khai thành công! 🎉**
