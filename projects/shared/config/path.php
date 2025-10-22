<?php
// Get root folder dynamically
$rootPath = realpath(__DIR__ . '/../../');

// Define common directories
define('BASE_URL', '/NUMCLOTHING_PROJECT/projects'); // ⚠️ Case-sensitive, adjust if needed

define('ADMIN_PATH', $rootPath . '/admin');
define('CUSTOMER_PATH', $rootPath . '/customer');
define('SHARED_PATH', $rootPath . '/shared');
define('CONFIG_PATH', SHARED_PATH . '/config');
define('IMAGES_PATH', $rootPath . '/images');
