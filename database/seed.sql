-- Seed Data for Phone Shop
-- Created: November 23, 2025
-- Chạy file này sau khi đã chạy schema.sql

USE phone_shop;

-- ============================================
-- Seed Users
-- Password mặc định cho tất cả: "123456"
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
-- ============================================

-- Admin account
INSERT INTO users (name, email, phone, password, role) VALUES
('Admin Nguyễn Văn A', 'admin@phoneshop.com', '0901234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Customer accounts
INSERT INTO users (name, email, phone, password, role) VALUES
('Trần Thị B', 'tranthib@gmail.com', '0912345678', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer'),
('Lê Văn C', 'levanc@gmail.com', '0923456789', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer'),
('Phạm Thị D', 'phamthid@gmail.com', '0934567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer');

-- ============================================
-- Seed Brands
-- ============================================
INSERT INTO brands (name, slug, description, logo) VALUES
('Apple', 'apple', 'Thương hiệu công nghệ hàng đầu thế giới từ Mỹ, nổi tiếng với dòng iPhone, iPad và Macbook.', 'apple-logo.png'),
('Samsung', 'samsung', 'Tập đoàn điện tử lớn nhất Hàn Quốc, dẫn đầu thị trường smartphone Android toàn cầu.', 'samsung-logo.png'),
('Xiaomi', 'xiaomi', 'Thương hiệu công nghệ từ Trung Quốc, nổi tiếng với các sản phẩm chất lượng cao và giá cả hợp lý.', 'xiaomi-logo.png'),
('Oppo', 'oppo', 'Thương hiệu điện thoại đến từ Trung Quốc, chuyên về camera và thiết kế thời trang.', 'oppo-logo.png'),
('Vivo', 'vivo', 'Thương hiệu smartphone nổi tiếng với công nghệ camera selfie và màn hình đẹp.', 'vivo-logo.png'),
('Realme', 'realme', 'Thương hiệu trẻ trung, năng động với các sản phẩm giá tốt dành cho giới trẻ.', 'realme-logo.png');

-- ============================================
-- Seed Products - Apple
-- ============================================
INSERT INTO products (brand_id, name, slug, description, specs, price, image, stock) VALUES
(1, 'iPhone 15 Pro Max 256GB', 'iphone-15-pro-max-256gb', 
'iPhone 15 Pro Max là chiếc điện thoại cao cấp nhất của Apple với chip A17 Pro mạnh mẽ, camera 48MP và khung titan sang trọng.',
'{"screen": "6.7 inch, Super Retina XDR OLED", "cpu": "Apple A17 Pro", "ram": "8GB", "storage": "256GB", "camera": "48MP + 12MP + 12MP", "battery": "4422mAh", "os": "iOS 17"}',
29990000, 'uploads/images/placeholder.svg', 50),

(1, 'iPhone 15 Pro 128GB', 'iphone-15-pro-128gb',
'iPhone 15 Pro với thiết kế titan cao cấp, chip A17 Pro và camera 48MP chuyên nghiệp.',
'{"screen": "6.1 inch, Super Retina XDR OLED", "cpu": "Apple A17 Pro", "ram": "8GB", "storage": "128GB", "camera": "48MP + 12MP + 12MP", "battery": "3274mAh", "os": "iOS 17"}',
25990000, 'uploads/images/placeholder.svg', 45),

(1, 'iPhone 15 Plus 128GB', 'iphone-15-plus-128gb',
'iPhone 15 Plus màn hình lớn 6.7 inch, chip A16 Bionic và camera 48MP ấn tượng.',
'{"screen": "6.7 inch, Super Retina XDR OLED", "cpu": "Apple A16 Bionic", "ram": "6GB", "storage": "128GB", "camera": "48MP + 12MP", "battery": "4383mAh", "os": "iOS 17"}',
22990000, 'uploads/images/placeholder.svg', 60),

(1, 'iPhone 14 128GB', 'iphone-14-128gb',
'iPhone 14 với thiết kế sang trọng, hiệu năng mạnh mẽ và hệ thống camera kép xuất sắc.',
'{"screen": "6.1 inch, Super Retina XDR OLED", "cpu": "Apple A15 Bionic", "ram": "6GB", "storage": "128GB", "camera": "12MP + 12MP", "battery": "3279mAh", "os": "iOS 17"}',
18990000, 'uploads/images/placeholder.svg', 70);

-- ============================================
-- Seed Products - Samsung
-- ============================================
INSERT INTO products (brand_id, name, slug, description, specs, price, image, stock) VALUES
(2, 'Samsung Galaxy S24 Ultra 256GB', 'samsung-galaxy-s24-ultra-256gb',
'Galaxy S24 Ultra là flagship hàng đầu của Samsung với chip Snapdragon 8 Gen 3, camera 200MP và bút S Pen tích hợp.',
'{"screen": "6.8 inch, Dynamic AMOLED 2X, 120Hz", "cpu": "Snapdragon 8 Gen 3", "ram": "12GB", "storage": "256GB", "camera": "200MP + 50MP + 12MP + 10MP", "battery": "5000mAh", "os": "Android 14"}',
27990000, 'uploads/images/placeholder.svg', 40),

(2, 'Samsung Galaxy S24 Plus 256GB', 'samsung-galaxy-s24-plus-256gb',
'Galaxy S24 Plus với màn hình lớn, hiệu năng cao và camera AI thông minh.',
'{"screen": "6.7 inch, Dynamic AMOLED 2X, 120Hz", "cpu": "Snapdragon 8 Gen 3", "ram": "12GB", "storage": "256GB", "camera": "50MP + 12MP + 10MP", "battery": "4900mAh", "os": "Android 14"}',
23990000, 'uploads/images/placeholder.svg', 55),

(2, 'Samsung Galaxy Z Flip5 256GB', 'samsung-galaxy-z-flip5-256gb',
'Galaxy Z Flip5 điện thoại gập vỏ sò thời trang với màn hình phụ lớn và thiết kế độc đáo.',
'{"screen": "6.7 inch, Dynamic AMOLED 2X, 120Hz", "cpu": "Snapdragon 8 Gen 2", "ram": "8GB", "storage": "256GB", "camera": "12MP + 12MP", "battery": "3700mAh", "os": "Android 13"}',
21990000, 'uploads/images/placeholder.svg', 30),

(2, 'Samsung Galaxy A54 5G 128GB', 'samsung-galaxy-a54-5g-128gb',
'Galaxy A54 5G tầm trung với camera 50MP, màn hình Super AMOLED và pin 5000mAh bền bỉ.',
'{"screen": "6.4 inch, Super AMOLED, 120Hz", "cpu": "Exynos 1380", "ram": "8GB", "storage": "128GB", "camera": "50MP + 12MP + 5MP", "battery": "5000mAh", "os": "Android 13"}',
9990000, 'uploads/images/placeholder.svg', 100);

-- ============================================
-- Seed Products - Xiaomi
-- ============================================
INSERT INTO products (brand_id, name, slug, description, specs, price, image, stock) VALUES
(3, 'Xiaomi 14 Ultra 512GB', 'xiaomi-14-ultra-512gb',
'Xiaomi 14 Ultra là flagship cao cấp với camera Leica, chip Snapdragon 8 Gen 3 và sạc nhanh 90W.',
'{"screen": "6.73 inch, AMOLED, 120Hz", "cpu": "Snapdragon 8 Gen 3", "ram": "16GB", "storage": "512GB", "camera": "50MP + 50MP + 50MP + 50MP", "battery": "5000mAh", "os": "Android 14"}',
24990000, 'uploads/images/placeholder.svg', 35),

(3, 'Xiaomi 13T Pro 256GB', 'xiaomi-13t-pro-256gb',
'Xiaomi 13T Pro với camera Leica, chip MediaTek Dimensity 9200+ và sạc siêu nhanh 120W.',
'{"screen": "6.67 inch, AMOLED, 144Hz", "cpu": "MediaTek Dimensity 9200+", "ram": "12GB", "storage": "256GB", "camera": "50MP + 50MP + 12MP", "battery": "5000mAh", "os": "Android 13"}',
12990000, 'uploads/images/placeholder.svg', 60),

(3, 'Redmi Note 13 Pro 5G 256GB', 'redmi-note-13-pro-5g-256gb',
'Redmi Note 13 Pro 5G với camera 200MP, màn hình AMOLED và giá cả phải chăng.',
'{"screen": "6.67 inch, AMOLED, 120Hz", "cpu": "Snapdragon 7s Gen 2", "ram": "8GB", "storage": "256GB", "camera": "200MP + 8MP + 2MP", "battery": "5100mAh", "os": "Android 13"}',
7990000, 'uploads/images/placeholder.svg', 80),

(3, 'Redmi 12 128GB', 'redmi-12-128gb',
'Redmi 12 giá rẻ với pin khủng 5000mAh và hiệu năng ổn định cho nhu cầu cơ bản.',
'{"screen": "6.79 inch, IPS LCD, 90Hz", "cpu": "MediaTek Helio G88", "ram": "8GB", "storage": "128GB", "camera": "50MP + 8MP + 2MP", "battery": "5000mAh", "os": "Android 13"}',
3990000, 'uploads/images/placeholder.svg', 120);

-- ============================================
-- Seed Products - Oppo
-- ============================================
INSERT INTO products (brand_id, name, slug, description, specs, price, image, stock) VALUES
(4, 'Oppo Find N3 Flip 256GB', 'oppo-find-n3-flip-256gb',
'Oppo Find N3 Flip điện thoại gập vỏ sò với camera 50MP và màn hình phụ lớn tiện dụng.',
'{"screen": "6.8 inch, AMOLED, 120Hz", "cpu": "MediaTek Dimensity 9200", "ram": "12GB", "storage": "256GB", "camera": "50MP + 48MP + 32MP", "battery": "4300mAh", "os": "Android 13"}',
19990000, 'uploads/images/placeholder.svg', 25),

(4, 'Oppo Reno11 5G 256GB', 'oppo-reno11-5g-256gb',
'Oppo Reno11 5G thiết kế mỏng nhẹ, camera 50MP và sạc nhanh SuperVOOC 67W.',
'{"screen": "6.7 inch, AMOLED, 120Hz", "cpu": "MediaTek Dimensity 8200", "ram": "12GB", "storage": "256GB", "camera": "50MP + 32MP + 8MP", "battery": "4800mAh", "os": "Android 14"}',
10990000, 'uploads/images/placeholder.svg', 70),

(4, 'Oppo A78 5G 128GB', 'oppo-a78-5g-128gb',
'Oppo A78 5G tầm trung với thiết kế đẹp, pin 5000mAh và hỗ trợ 5G.',
'{"screen": "6.56 inch, IPS LCD, 90Hz", "cpu": "MediaTek Dimensity 700", "ram": "8GB", "storage": "128GB", "camera": "50MP + 2MP", "battery": "5000mAh", "os": "Android 13"}',
6490000, 'uploads/images/placeholder.svg', 90);

-- ============================================
-- Seed Products - Vivo
-- ============================================
INSERT INTO products (brand_id, name, slug, description, specs, price, image, stock) VALUES
(5, 'Vivo V29 5G 256GB', 'vivo-v29-5g-256gb',
'Vivo V29 5G chuyên selfie với camera trước 50MP, chip Snapdragon 778G và sạc nhanh 80W.',
'{"screen": "6.78 inch, AMOLED, 120Hz", "cpu": "Snapdragon 778G", "ram": "12GB", "storage": "256GB", "camera": "50MP + 8MP + 2MP", "battery": "4600mAh", "os": "Android 13"}',
10990000, 'uploads/images/placeholder.svg', 65),

(5, 'Vivo Y36 128GB', 'vivo-y36-128gb',
'Vivo Y36 giá tốt với pin 5000mAh, camera 50MP và thiết kế trẻ trung.',
'{"screen": "6.64 inch, IPS LCD, 90Hz", "cpu": "Snapdragon 680", "ram": "8GB", "storage": "128GB", "camera": "50MP + 2MP", "battery": "5000mAh", "os": "Android 13"}',
5490000, 'uploads/images/placeholder.svg', 100);

-- ============================================
-- Seed Products - Realme
-- ============================================
INSERT INTO products (brand_id, name, slug, description, specs, price, image, stock) VALUES
(6, 'Realme 11 Pro+ 5G 256GB', 'realme-11-pro-plus-5g-256gb',
'Realme 11 Pro+ 5G với camera 200MP, màn hình cong AMOLED và sạc nhanh 100W.',
'{"screen": "6.7 inch, AMOLED, 120Hz", "cpu": "MediaTek Dimensity 7050", "ram": "12GB", "storage": "256GB", "camera": "200MP + 8MP + 2MP", "battery": "5000mAh", "os": "Android 13"}',
10990000, 'uploads/images/placeholder.svg', 50),

(6, 'Realme C55 128GB', 'realme-c55-128gb',
'Realme C55 giá rẻ với camera 64MP, sạc nhanh 33W và pin 5000mAh.',
'{"screen": "6.72 inch, IPS LCD, 90Hz", "cpu": "MediaTek Helio G88", "ram": "8GB", "storage": "128GB", "camera": "64MP + 2MP", "battery": "5000mAh", "os": "Android 13"}',
4490000, 'uploads/images/placeholder.svg', 110);

-- ============================================
-- Seed Sample Orders (cho demo)
-- ============================================
INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, total_amount, status, payment_method) VALUES
(2, 'Trần Thị B', '0912345678', '123 Nguyễn Huệ, Quận 1, TP.HCM', 29990000, 'delivered', 'COD'),
(3, 'Lê Văn C', '0923456789', '456 Lê Lợi, Quận 5, TP.HCM', 18990000, 'processing', 'COD'),
(4, 'Phạm Thị D', '0934567890', '789 Trần Hưng Đạo, Quận 10, TP.HCM', 47980000, 'pending', 'COD');

-- Sample order items
INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES
(1, 1, 'iPhone 15 Pro Max 256GB', 1, 29990000),
(2, 4, 'iPhone 14 128GB', 1, 18990000),
(3, 1, 'iPhone 15 Pro Max 256GB', 1, 29990000),
(3, 4, 'iPhone 14 128GB', 1, 18990000);
