-- ============================================
-- Fix Brand Logo 404 Errors
-- Date: 2025-11-27
-- ============================================

-- Set all brand logos to NULL since actual image files don't exist
-- This prevents 404 errors when displaying brands
UPDATE brands SET logo = NULL;

-- IMPORTANT: Brand logos should be uploaded through Admin panel at:
-- /admin/brands/edit/{id}
-- Files will be saved to: public/uploads/brands/
-- Logo path in database will be: uploads/brands/filename.ext

-- If you want to manually add logo files:
-- 1. Upload image files to: C:\xampp\htdocs\Phone_Shop\Phone_Shop\public\uploads\brands\
-- 2. Update database with relative path (from public/ directory)

-- Example for manual logo updates (after uploading files):
-- UPDATE brands SET logo = 'uploads/brands/apple-logo.png' WHERE slug = 'apple';
-- UPDATE brands SET logo = 'uploads/brands/samsung-logo.png' WHERE slug = 'samsung';
-- UPDATE brands SET logo = 'uploads/brands/xiaomi-logo.png' WHERE slug = 'xiaomi';
-- UPDATE brands SET logo = 'uploads/brands/oppo-logo.png' WHERE slug = 'oppo';
-- UPDATE brands SET logo = 'uploads/brands/vivo-logo.png' WHERE slug = 'vivo';
-- UPDATE brands SET logo = 'uploads/brands/realme-logo.png' WHERE slug = 'realme';

-- Verify the update
SELECT id, name, slug, logo FROM brands;
