<?php
define('BASE_URL', '/ChaJoy/');

define('DELIVERY_CHARGE', 50.00);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../includes/functions.php';

define('IMAGE_URL', BASE_URL . 'public/images/');