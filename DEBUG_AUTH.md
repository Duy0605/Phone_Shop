# DEBUG - Chức năng Đăng ký & Đăng nhập

## Các vấn đề đã sửa:

### 1. ✅ Form Action bị thiếu

**Vấn đề**: Form đăng ký và đăng nhập có `action=""` (rỗng)
**Hậu quả**: Form submit về URL hiện tại thay vì POST đến route xử lý
**Giải pháp**:

-   `register.php`: Thêm `action="<?= url('/register') ?>"`
-   `login.php`: Thêm `action="<?= url('/login') ?>"`

### 2. ⚠️ Validation số điện thoại không nhất quán

**Vấn đề**:

-   Pattern HTML trong form: `[0-9]{10,11}` (cho phép 10-11 chữ số)
-   Pattern PHP validation: `^0[35789][0-9]{8}$` (chỉ cho phép 10 chữ số, bắt đầu 03/05/07/08/09)

**Giải pháp**: Cần thống nhất validation

## Cách test:

### Test Đăng ký:

1. Truy cập: `http://localhost:8888/Phone_Shop/Phone_Shop/public/register`
2. Nhập thông tin:
    - Họ tên: Test User
    - Email: test@example.com
    - Số điện thoại: 0912345678 (10 số, bắt đầu 09)
    - Mật khẩu: 123456
    - Xác nhận: 123456
3. Click "Đăng ký"
4. **Mong đợi**: Redirect về `/login` với thông báo "Đăng ký thành công"

### Test Đăng nhập:

1. Truy cập: `http://localhost:8888/Phone_Shop/Phone_Shop/public/login`
2. Nhập:
    - Email: test@example.com (hoặc email đã đăng ký)
    - Mật khẩu: 123456
3. Click "Đăng nhập"
4. **Mong đợi**: Redirect về `/` (trang chủ) với thông báo chào mừng

### Test với tài khoản Admin:

1. Login với:
    - Email: admin@phoneshop.com
    - Mật khẩu: admin123
2. **Mong đợi**: Redirect về `/admin/dashboard`

## Các điểm cần kiểm tra thêm:

1. **Session có hoạt động không?**
    - Kiểm tra file `public/index.php` có `session_start()` chưa
2. **Database connection có OK không?**
    - Test query đơn giản: `SELECT * FROM users LIMIT 1`
3. **Password hash có đúng không?**

    - Xem file `database/update_passwords.sql` đã chạy chưa
    - Admin password hash: `$2y$10$wtlIl9h6FUwba9Q4n.jHpuEK0LE7L9h0/KPRce1cr6yxLJdrulJBW`

4. **Routing có hoạt động không?**
    - POST `/register` → `AuthController@register`
    - POST `/login` → `AuthController@login`

## Nếu vẫn không hoạt động:

### Debug bằng cách thêm log:

Trong `AuthController::register()`, thêm ngay đầu function:

```php
error_log("=== REGISTER DEBUG ===");
error_log("Method: " . $_SERVER['REQUEST_METHOD']);
error_log("POST data: " . print_r($_POST, true));
```

Trong `AuthController::login()`, thêm:

```php
error_log("=== LOGIN DEBUG ===");
error_log("Method: " . $_SERVER['REQUEST_METHOD']);
error_log("Email: " . ($email ?? 'NULL'));
```

Xem log tại: `C:\xampp\php\logs\php_error_log`
