<?php
echo "<h3>Debug URL Helper</h3>";
echo "<pre>";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "\n";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'not set') . "\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "\n";
echo "\n";

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$baseDir = str_replace('\\', '/', dirname($scriptName));
echo "baseDir: $baseDir\n";

// Test url function
require_once __DIR__ . '/../autoload.php';

echo "\n--- Test url() function ---\n";
echo "url('/'): " . url('/') . "\n";
echo "url('/products'): " . url('/products') . "\n";
echo "url('/orders'): " . url('/orders') . "\n";
echo "</pre>";
