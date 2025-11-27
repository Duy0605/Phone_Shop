# 📱 Phone Shop - Website Bán Điện Thoại

Website thương mại điện tử bán điện thoại với quản trị admin, được xây dựng bằng PHP MVC thuần.

## 📚 Mục Lục

1. [Tổng Quan](#tổng-quan)
2. [Công Nghệ](#công-nghệ)
3. [Cài Đặt](#cài-đặt)
4. [Cấu Trúc Project](#cấu-trúc-project)
5. [Tài Liệu Kỹ Thuật](#tài-liệu-kỹ-thuật)
6. [Hướng Dẫn Sử Dụng](#hướng-dẫn-sử-dụng)
7. [Bảo Mật](#bảo-mật)

---

## 🎯 Tổng Quan

### Đối Tượng Sử Dụng

-   **Khách hàng**: Xem sản phẩm, tìm kiếm, đặt hàng, quản lý tài khoản
-   **Admin**: Quản lý sản phẩm, đơn hàng, thương hiệu, khách hàng

### Tính Năng Chính

#### Khách Hàng

-   ✅ Xem sản phẩm (Featured, Latest, By Brand)
-   ✅ Tìm kiếm & lọc sản phẩm
-   ✅ Giỏ hàng (AJAX)
-   ✅ Đặt hàng (COD)
-   ✅ Quản lý tài khoản & đơn hàng
-   ✅ Đăng ký/Đăng nhập

#### Admin Panel

-   ✅ Dashboard với thống kê
-   ✅ Quản lý sản phẩm (CRUD)
-   ✅ Quản lý thương hiệu (CRUD)
-   ✅ Quản lý đơn hàng & cập nhật trạng thái
-   ✅ Xem danh sách khách hàng

---

## 🛠️ Công Nghệ

### Backend

-   **PHP 7.4+** (Pure PHP, không framework)
-   **MySQL 5.7+**
-   **MVC Architecture** (Custom implementation)
-   **Session-based Authentication**

### Frontend

-   **HTML5, CSS3** (Responsive với Media Queries)
-   **JavaScript** (Vanilla JS, Fetch API)
-   **No frameworks** - Tất cả code thuần

### Security

-   ✅ Password hashing (`password_hash()`)
-   ✅ Prepared Statements (SQL Injection prevention)
-   ✅ XSS Protection (`htmlspecialchars()`)
-   ✅ Session security
-   ✅ Admin middleware protection

---

## 📦 Cài Đặt

### Yêu Cầu Hệ Thống

-   PHP >= 7.4
-   MySQL >= 5.7
-   Apache với mod_rewrite
-   XAMPP/WAMP (đề xuất)
-   XAMPP/WAMP (đề xuất)

### Bước 1: Clone/Download Project

```bash
# Copy project vào htdocs (XAMPP)
C:\xampp\htdocs\Phone_Shop\
```

### Bước 2: Tạo Database

1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Tạo database: `phone_shop`
3. Import file: `database/schema.sql`
4. Import dữ liệu mẫu: `database/seed.sql`

### Bước 3: Cấu Hình

Kiểm tra file `config/database.php`:

```php
return [
    'host' => 'localhost',
    'database' => 'phone_shop',
    'username' => 'root',
    'password' => ''
];
```

### Bước 4: Chạy Project

```
http://localhost/Phone_Shop/Phone_Shop/public/
```

### Tài Khoản Mặc Định

**Admin**:

-   Email: `admin@phoneshop.com`
-   Password: `admin123`

**User**:

-   Email: `user@example.com`
-   Password: `123456`

---

## 📂 Cấu Trúc Project

```
Phone_Shop/
├── app/
│   ├── Helper/
│   │   ├── auth.php          # Authentication helpers
│   │   ├── utils.php         # Utility functions
│   │   └── validation.php    # Validation helpers
│   ├── Http/
│   │   ├── Controllers/      # Business logic
│   │   │   ├── Admin/        # Admin controllers
│   │   │   ├── AuthController.php
│   │   │   ├── CartController.php
│   │   │   ├── HomeController.php
│   │   │   ├── OrderController.php
│   │   │   └── ProductController.php
│   │   ├── Middleware/       # Auth & Admin guards
│   │   └── Kernel.php        # Routing engine
│   └── Models/               # Database models
│       ├── BaseModel.php
│       ├── Brand.php
│       ├── Cart.php
│       ├── Order.php
│       ├── Product.php
│       └── User.php
├── config/
│   ├── app.php              # App configuration
│   └── database.php         # DB configuration
├── database/
│   ├── schema.sql           # Database structure
│   └── seed.sql             # Sample data
├── public/
│   ├── index.php            # Entry point
│   ├── resources/
│   │   ├── css/             # Stylesheets
│   │   │   ├── admin.css    # Admin styles
│   │   │   ├── home.css
│   │   │   ├── products.css
│   │   │   └── ...
│   │   └── js/
│   │       └── main.js      # JavaScript
│   └── uploads/
│       └── images/          # Product images
├── resources/view/
│   ├── components/          # ✨ Reusable components
│   │   ├── product-card.php
│   │   ├── search-form.php
│   │   ├── brand-filter.php
│   │   ├── status-badge.php
│   │   ├── empty-state.php
│   │   ├── admin-header.php
│   │   └── admin-footer.php
│   ├── layouts/
│   │   ├── header-component.php
│   │   └── footer-component.php
│   ├── admin/               # Admin views
│   │   ├── dashboard.php
│   │   ├── products/
│   │   ├── orders/
│   │   ├── brands/
│   │   └── customers/
│   ├── auth/                # Auth views
│   ├── cart/
│   ├── orders/
│   ├── products/
│   └── profile/
├── routes/
│   └── web.php              # Route definitions
├── autoload.php             # PSR-4 autoloader
├── README.md
├── HUONG_DAN_CHUYEN_MAY.md  # 📘 Deployment guide
├── HUONG_DAN_COMPONENTS.md  # 📘 Components guide
├── DANH_SACH_HELPERS.md     # 📘 Helper functions
├── BAO_CAO_TOI_UU_HOA.md    # 📊 Optimization report
└── VD_REFACTOR_ADMIN.md     # 💡 Refactor examples
```

---

## 📖 Tài Liệu Kỹ Thuật

### 1. [HUONG_DAN_CHUYEN_MAY.md](HUONG_DAN_CHUYEN_MAY.md)

Hướng dẫn deploy project lên máy khác, giải quyết vấn đề routing & base URL

**Nội dung**:

-   Cách config base URL tự động
-   Fix lỗi 404 routing
-   Checklist khi chuyển máy
-   Troubleshooting thường gặp

### 2. [HUONG_DAN_COMPONENTS.md](HUONG_DAN_COMPONENTS.md)

Hướng dẫn sử dụng reusable components để giảm code lặp

**Components có sẵn**:

-   `product-card.php` - Thẻ sản phẩm
-   `search-form.php` - Form tìm kiếm
-   `brand-filter.php` - Lọc thương hiệu
-   `status-badge.php` - Badge trạng thái đơn hàng
-   `empty-state.php` - Trạng thái rỗng
-   `admin-header.php` - Admin header
-   `admin-footer.php` - Admin footer

### 3. [DANH_SACH_HELPERS.md](DANH_SACH_HELPERS.md)

Danh sách đầy đủ helper functions và cách sử dụng

**Categories**:

-   **Routing**: `url()`, `redirect()`
-   **Request**: `post()`, `get()`, `request()`
-   **Security**: `escape()`
-   **Formatting**: `formatPrice()`, `formatDate()`, `createSlug()`
-   **Validation**: `validateEmail()`, `validatePhone()`, etc.
-   **Authentication**: `isLoggedIn()`, `isAdmin()`, `login()`, etc.

### 4. [BAO_CAO_TOI_UU_HOA.md](BAO_CAO_TOI_UU_HOA.md)

Báo cáo tối ưu hóa code, giảm code duplication

**Thành tựu**:

-   Giảm 50% code lặp (~2,250 dòng)
-   Centralized admin CSS (2,000 → 450 dòng)
-   7 reusable components
-   Maintainability cải thiện 86%

### 5. [VD_REFACTOR_ADMIN.md](VD_REFACTOR_ADMIN.md)

Ví dụ chi tiết cách refactor admin pages

**Nội dung**:

-   So sánh Before/After
-   Step-by-step refactoring
-   Checklist quality assurance

---

## 🚀 Hướng Dẫn Sử Dụng

### Khách Hàng

#### Đăng Ký & Đăng Nhập

```
1. Truy cập: /register
2. Nhập thông tin: Tên, Email, SĐT, Password
3. Submit → Tự động login → Redirect về trang chủ
```

#### Mua Sắm

```
1. Xem sản phẩm: Trang chủ, /products, /products/brand/{slug}
2. Tìm kiếm: /products/search?q=iphone
3. Thêm vào giỏ: Click "Thêm vào giỏ" (AJAX - không reload)
4. Xem giỏ: /cart
5. Thanh toán: /checkout → Nhập thông tin nhận hàng
6. Xem đơn hàng: /profile/orders
```

### Admin

#### Đăng Nhập Admin

```
1. Truy cập: /admin/login
2. Email: admin@phoneshop.com
3. Password: admin123
```

#### Quản Lý Sản Phẩm

```
1. Dashboard: /admin/dashboard
2. Danh sách: /admin/products
3. Thêm mới: /admin/products/create
4. Sửa: /admin/products/{id}/edit
5. Xóa: Click nút xóa → Confirm
```

#### Quản Lý Đơn Hàng

```
1. Danh sách: /admin/orders
2. Lọc theo status: Dropdown filter
3. Chi tiết: /admin/orders/{id}
4. Cập nhật trạng thái: Select → Submit
```

---

## 🔐 Bảo Mật

### Implemented Security Measures

#### 1. Password Security

```php
// Khi đăng ký
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Khi đăng nhập
if (password_verify($inputPassword, $hashedPassword)) {
    login($user);
}
```

#### 2. SQL Injection Prevention

```php
// ❌ WRONG
$sql = "SELECT * FROM users WHERE email = '$email'";

// ✅ RIGHT - Prepared Statements
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
```

#### 3. XSS Protection

```php
// Always escape output
echo escape($user['name']); // htmlspecialchars()
```

#### 4. Authentication Guards

```php
// User routes
requireAuth(); // Middleware

// Admin routes
requireAdmin(); // Middleware
```

#### 5. Session Security

```php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => false, // Set true on HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);
```

---

## 🎨 UI/UX Features

-   ✅ **Responsive Design** - Mobile, Tablet, Desktop
-   ✅ **AJAX Cart** - Add to cart without page reload
-   ✅ **Real-time Search** - Instant search results
-   ✅ **Product Filters** - By brand, price range
-   ✅ **Image Gallery** - Product images
-   ✅ **Order Tracking** - Customer order history
-   ✅ **Admin Dashboard** - Quick stats & charts

---

## 🧪 Testing

### Manual Testing Checklist

-   [ ] User registration & login
-   [ ] Product listing & detail view
-   [ ] Search & filter functionality
-   [ ] Add to cart (AJAX)
-   [ ] Checkout process
-   [ ] Order history
-   [ ] Admin login
-   [ ] Product CRUD
-   [ ] Order management
-   [ ] Mobile responsive

---

## 📈 Performance Optimization

### Database

-   ✅ Indexed columns: `id`, `slug`, `brand_id`, `user_id`
-   ✅ Optimized queries với JOIN
-   ✅ Pagination để giảm data load

### Frontend

-   ✅ Minified CSS
-   ✅ Optimized images
-   ✅ CSS caching (browser cache)
-   ✅ AJAX để giảm page reload

### Code Quality

-   ✅ DRY principle - Reusable components
-   ✅ MVC architecture
-   ✅ Separation of concerns
-   ✅ Code documentation

---

## 🐛 Troubleshooting

### Lỗi thường gặp:

#### 1. Lỗi 404 - Not Found

**Nguyên nhân**: Base URL không đúng hoặc .htaccess chưa config

**Giải pháp**: Xem [HUONG_DAN_CHUYEN_MAY.md](HUONG_DAN_CHUYEN_MAY.md)

#### 2. Form submit reset về trang trắng

**Nguyên nhân**: Form action URL sai

**Giải pháp**: Dùng relative URL hoặc `url()` helper

#### 3. CSS không load

**Nguyên nhân**: Path sai

**Giải pháp**: Dùng `url('/resources/css/file.css')`

#### 4. Admin không truy cập được

**Nguyên nhân**: Session không work hoặc middleware fail

**Giải pháp**: Check session config và clear browser cache

---

## 👥 Contributors

-   Developer: [Your Name]
-   Assisted by: GitHub Copilot

---

## 📄 License

Tùy chọn - Có thể license
Hệ thống có hai đối tượng sử dụng chính:
• Khách hàng:
o Khách vãng lai: Người dùng chưa đăng nhập. Có thể xem sản phẩm, tìm kiếm, thêm vào giỏ hàng.
o Khách đã đăng ký: Người dùng đã có tài khoản. Có các quyền như khách vãng lai, cộng thêm: đặt hàng, quản lý thông tin cá nhân, xem lịch sử đơn hàng.
• Quản trị viên:
o Người chịu trách nhiệm vận hành website. Có quyền truy cập vào khu vực quản trị riêng biệt để quản lý toàn bộ nội dung và hoạt động của website.
1.2. Phạm vi hoạt động
• Phía Khách hàng:
o Trang chủ: Hiển thị sản phẩm nổi bật, sản phẩm mới, khuyến mãi.
o Trang danh sách sản phẩm: Hiển thị sản phẩm theo danh mục (thương hiệu), cho phép lọc (theo giá, hãng...) và tìm kiếm.
o Trang chi tiết sản phẩm: Hiển thị thông tin chi tiết, hình ảnh, thông số kỹ thuật, giá bán.
o Giỏ hàng: Cho phép thêm/xóa/cập nhật số lượng sản phẩm.
o Thanh toán: Form nhập thông tin nhận hàng và đặt hàng (chủ yếu là COD - Trả tiền khi nhận hàng - cho hệ thống cơ bản).
o Đăng ký / Đăng nhập: Quản lý tài khoản khách hàng.
o Trang cá nhân: Xem/cập nhật thông tin cá nhân, xem lịch sử đơn hàng.
• Phía Quản trị:
o Đăng nhập quản trị.
o Dashboard: Thống kê nhanh (số đơn hàng mới, doanh thu cơ bản).
o Quản lý Sản phẩm: Thêm, xóa, sửa sản phẩm (tên, giá, mô tả, hình ảnh, số lượng tồn kho).
o Quản lý Danh mục/Thương hiệu: Thêm, xóa, sửa các thương hiệu (Apple, Samsung, Xiaomi...).
o Quản lý Đơn hàng: Xem danh sách đơn hàng, cập nhật trạng thái đơn hàng (Mới, Đang xử lý, Đã giao, Đã hủy).
o Quản lý Người dùng: Xem danh sách khách hàng đã đăng ký. 2. Yêu cầu chức năng
2.1. Chức năng cho Khách hàng
• Đăng ký tài khoản: Khách hàng cung cấp thông tin (tên, email, SĐT, mật khẩu) để tạo tài khoản.
• Đăng nhập: Khách hàng sử dụng email/SĐT và mật khẩu để đăng nhập.
• Quản lý tài khoản: Khách hàng có thể xem và cập nhật thông tin cá nhân, đổi mật khẩu.
• Xem sản phẩm:
o Xem danh sách sản phẩm.
o Xem chi tiết sản phẩm (thông số, hình ảnh, giá).
• Tìm kiếm sản phẩm: Tìm sản phẩm theo tên.
• Lọc sản phẩm: Lọc sản phẩm theo khoảng giá, theo thương hiệu.
• Quản lý giỏ hàng:
o Thêm sản phẩm vào giỏ.
o Cập nhật số lượng sản phẩm trong giỏ.
o Xóa sản phẩm khỏi giỏ.
• Đặt hàng:
o Khách hàng (đã đăng nhập) điền thông tin giao hàng (tên, SĐT, địa chỉ).
o Hệ thống xác nhận đơn hàng và tạo một đơn hàng mới ở trạng thái "Chờ xử lý".
• Xem lịch sử đơn hàng: Khách hàng (đã đăng nhập) xem lại các đơn hàng đã đặt và trạng thái của chúng.
2.2. Chức năng cho Quản trị viên
• Đăng nhập Admin: Đăng nhập vào khu vực quản trị với tài khoản admin.
• Quản lý Sản phẩm:
o Tạo sản phẩm mới (tên, mô tả, giá, thông số, hình ảnh, thương hiệu, số lượng tồn).
o Xem danh sách sản phẩm.
o Cập nhật thông tin sản phẩm.
o Xóa sản phẩm.
• Theo dõi doanh thu:
o Xem tổng số doanh thu theo ngày, tháng, năm.
o Xem tổng số doanh thu của từng sản phẩm.
• Quản lý Đơn hàng:
o Xem danh sách tất cả đơn hàng.
o Xem chi tiết một đơn hàng (sản phẩm, số lượng, thông tin khách hàng).
o Cập nhật trạng thái đơn hàng (VD: từ "Chờ xử lý" -> "Đang giao hàng").
• Quản lý Khách hàng: Xem danh sách khách hàng đã đăng ký. 3. Yêu cầu phi chức năng
• Bảo mật (Security):
o Mật khẩu: Tất cả mật khẩu người dùng (cả khách hàng và admin) phải được hash trước khi lưu vào CSDL.
o Chống SQL Injection: Tuyệt đối không viết câu lệnh SQL bằng cách nối chuỗi với dữ liệu từ người dùng. Phải sử dụng Prepared Statements (thông qua mysqli hoặc PDO) để truy vấn CSDL.
o Chống XSS (Cross-Site Scripting): Mọi dữ liệu do người dùng nhập (tên, mô tả, bình luận...) phải được lọc/escape (sử dụng htmlspecialchars()) trước khi hiển thị ra HTML.
o Phân quyền: Phải có cơ chế Session/Cookie để xác thực. Admin không thể truy cập trang khách hàng (khi đã đăng nhập admin) và ngược lại. Các trang admin phải kiểm tra quyền truy cập ở đầu mỗi file.
• Hiệu suất (Performance):
o Website phải tải nhanh. Hình ảnh sản phẩm cần được nén và tối ưu hóa kích thước trước khi tải lên.
o Các câu lệnh truy vấn CSDL (đặc biệt là các lệnh JOIN và SELECT ở trang chủ) phải được tối ưu, sử dụng INDEX cho các cột thường xuyên được tìm kiếm (như product_id, brand_id).
• Khả năng sử dụng (Usability):
o Giao diện phải thân thiện, dễ sử dụng.
o Website phải có Responsive Design (tương thích trên cả máy tính và điện thoại di động) – điều này rất quan trọng với website bán điện thoại. (Thực hiện bằng CSS thuần, sử dụng Media Queries).

• Tính tương thích (Compatibility):
o Hoạt động tốt trên các trình duyệt web hiện đại (Chrome, Firefox, Safari, Edge). 4. Yêu cầu công nghệ
4.1. Backend
• Ngôn ngữ: PHP.
• Kiến trúc: Tổ chức code theo mô hình MVC (Model-View-Controller) để dễ quản lý.
4.2. Frontend
• Ngôn ngữ: HTML, CSS, và JavaScript.
• AJAX: Sử dụng fetch() API (của JS thuần) để gửi request (VD: thêm vào giỏ hàng, cập nhật giỏ hàng) lên các file PHP backend mà không cần tải lại trang. Backend PHP sẽ nhận request này và trả về dữ liệu dạng JSON.
4.3. Cơ sở dữ liệu
• Hệ quản trị CSDL: MySQL.
• Công cụ quản lý: PhpMyAdmin.

//HƯỚNG DẪN XÂY DỰNG HỆ THỐNG WEBSITE BÁN ĐIỆN THOẠI BẰNG PHP MVC TỪ ĐẦU
BƯỚC 1: THIẾT LẬP CƠ SỞ DỮ LIỆU (Database)
1.1. Tạo database schema
Tạo file database/schema.sql với các bảng:
users (id, name, email, phone, password, role, created_at)
brands (id, name, slug, description, logo)
products (id, brand_id, name, slug, description, price, specs, image, stock, created_at)
carts (id, user_id, created_at)
cart_items (id, cart_id, product_id, quantity)
orders (id, user_id, customer_name, phone, address, total_amount, status, created_at)
order_items (id, order_id, product_id, quantity, price)
1.2. Tạo dữ liệu mẫu
File database/seed.sql với:
Admin user mặc định
Một số thương hiệu (Apple, Samsung, Xiaomi, Oppo)
Sản phẩm mẫu
BƯỚC 2: CẤU HÌNH CƠ BẢN (Configuration)
2.1. File database.php
Cấu hình kết nối MySQL (host, database, username, password)
2.2. File app.php
Base URL, timezone, session config
2.3. File autoload.php
Autoloader cho các class Models, Controllers, Middleware
BƯỚC 3: XÂY DỰNG MODELS (Tầng dữ liệu)
3.1. BaseModel
Kết nối database
Các method cơ bản: find(), findAll(), create(), update(), delete()
Sử dụng Prepared Statements
3.2. Các Model cụ thể
User.php - Xác thực, phân quyền
Product.php - CRUD sản phẩm, tìm kiếm, lọc
Brand.php - Quản lý thương hiệu
Cart.php & CartItem.php - Giỏ hàng
Order.php & OrderItem.php - Đơn hàng
BƯỚC 4: HELPERS & MIDDLEWARE
4.1. Helper functions
auth.php: login(), logout(), isAuthenticated(), isAdmin(), getCurrentUser()
validation.php: validateEmail(), validatePhone(), validateRequired()
utils.php: redirect(), escape(), formatPrice(), uploadImage()
4.2. Middleware
AuthMiddleware.php - Kiểm tra đăng nhập
AdminMiddleware.php - Kiểm tra quyền admin
BƯỚC 5: ROUTING SYSTEM
5.1. File routes/web.php
Định nghĩa các routes cho customer và admin
Map URL với Controller@method
5.2. File Kernel.php
Route dispatcher
Middleware handler
BƯỚC 6: CONTROLLERS (Xử lý logic)
6.1. Customer Controllers
HomeController.php - Trang chủ, hiển thị sản phẩm nổi bật
ProductController.php - Danh sách, chi tiết, tìm kiếm, lọc
AuthController.php - Đăng ký, đăng nhập, đăng xuất, profile
CartController.php - Thêm/xóa/cập nhật giỏ hàng (AJAX)
OrderController.php - Checkout, đặt hàng, lịch sử
6.2. Admin Controllers
Admin\DashboardController.php - Thống kê
Admin\ProductController.php - CRUD sản phẩm
Admin\BrandController.php - CRUD thương hiệu
Admin\OrderController.php - Quản lý đơn hàng
Admin\CustomerController.php - Danh sách khách hàng
BƯỚC 7: VIEWS (Giao diện)
7.1. Layout chung
resources/view/layouts/main.php - Header, footer cho customer
resources/view/layouts/admin.php - Layout admin panel
7.2. Customer Views
home.php - Trang chủ
products/index.php - Danh sách sản phẩm
products/detail.php - Chi tiết sản phẩm
cart/index.php - Giỏ hàng
checkout.php - Thanh toán
auth/login.php, auth/register.php
profile/index.php, profile/orders.php
7.3. Admin Views
admin/dashboard.php
admin/products/index.php, admin/products/create.php, admin/products/edit.php
admin/brands/index.php
admin/orders/index.php, admin/orders/detail.php
admin/customers/index.php
BƯỚC 8: FRONTEND ASSETS
8.1. CSS
resources/css/style.css - Style chung
resources/css/admin.css - Style admin
Responsive design với Media Queries
8.2. JavaScript
resources/js/cart.js - AJAX cho giỏ hàng
resources/js/product.js - Filter, search
resources/js/admin.js - Xác nhận xóa, upload ảnh
BƯỚC 9: ENTRY POINT
9.1. File index.php
Session start
Load autoloader
Load config
Initialize router
Handle request
BƯỚC 10: BẢO MẬT & TỐI ƯU
10.1. Security
✅ Hash password với password_hash()
✅ Prepared Statements
✅ htmlspecialchars() cho output
✅ CSRF protection
✅ Session security
10.2. Performance
Optimize queries với INDEX
Image optimization
Caching cơ bản
BƯỚC 11: TESTING & DEPLOYMENT
11.1. Testing
Test đăng ký/đăng nhập
Test giỏ hàng và đặt hàng
Test admin panel
Test trên mobile
11.2. Deployment
Upload lên XAMPP
Import database
Cấu hình file permissions
Test trên localhost

## 📄 License

Project học tập - Free to use

---

## 📞 Support

Nếu gặp vấn đề, tham khảo:

1. [HUONG_DAN_CHUYEN_MAY.md](HUONG_DAN_CHUYEN_MAY.md) - Setup & Deployment
2. [HUONG_DAN_COMPONENTS.md](HUONG_DAN_COMPONENTS.md) - Components Usage
3. [DANH_SACH_HELPERS.md](DANH_SACH_HELPERS.md) - Helper Functions
4. [BAO_CAO_TOI_UU_HOA.md](BAO_CAO_TOI_UU_HOA.md) - Optimization Details

---

**Built with ❤️ using Pure PHP**
