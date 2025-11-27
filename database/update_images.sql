-- Update all product images to use placeholder
-- Run this script to fix image paths in existing database

USE phone_shop;

UPDATE products 
SET image = 'uploads/images/placeholder.svg'
WHERE image NOT LIKE 'uploads/%';

-- Verify the update
SELECT id, name, image FROM products LIMIT 10;
