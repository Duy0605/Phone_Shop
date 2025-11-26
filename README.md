1. Mô tả tổng quan
   Hệ thống website bán điện thoại là một nền tảng thương mại điện tử cho phép khách hàng xem, tìm kiếm, và mua các sản phẩm điện thoại di động trực tuyến. Hệ thống cũng cung cấp một trang quản trị (Admin Panel) cho phép người quản lý cập nhật sản phẩm, xem xét đơn hàng và quản lý người dùng.
   1.1. Đối tượng sử dụng
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
   o Quản lý Người dùng: Xem danh sách khách hàng đã đăng ký.
2. Yêu cầu chức năng
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
   • Quản lý Khách hàng: Xem danh sách khách hàng đã đăng ký.
3. Yêu cầu phi chức năng
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
