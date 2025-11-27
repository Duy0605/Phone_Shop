-- Update Admin Password
-- Chạy script này trong phpMyAdmin để cập nhật password admin

USE phone_shop;

-- Update password admin thành 'admin123'
UPDATE users 
SET password = '$2y$10$wtlIl9h6FUwba9Q4n.jHpuEK0LE7L9h0/KPRce1cr6yxLJdrulJBW'
WHERE email = 'admin@phoneshop.com' AND role = 'admin';

-- Update password customers thành '123456'
UPDATE users 
SET password = '$2y$10$gRAre/PUNC3aenlmfghmxe0oJpUSIo9N9AyGYGRe89c9AijLqP4tm'
WHERE role = 'customer';

-- Verify update
SELECT 
    id, 
    name, 
    email, 
    role,
    CASE 
        WHEN role = 'admin' THEN 'admin123'
        ELSE '123456'
    END as password_hint,
    created_at
FROM users
ORDER BY role DESC, id ASC;
