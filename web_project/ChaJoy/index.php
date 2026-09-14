<?php

require_once __DIR__ . '/config/config.php';


require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Category.php';
require_once __DIR__ . '/models/Beverage.php';
require_once __DIR__ . '/models/Cart.php';
require_once __DIR__ . '/models/Order.php';
require_once __DIR__ . '/models/Payment.php';
require_once __DIR__ . '/models/Delivery.php';

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/CustomerController.php';
require_once __DIR__ . '/controllers/BeverageController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/OrderController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/DeliveryController.php';

$page = $_GET['page'] ?? 'home';


$ajaxRoutes = [
    'ajax_beverage_search', 'ajax_cart_add', 'ajax_cart_update',
    'ajax_cart_remove', 'ajax_order_status_update', 'ajax_delivery_pickup',
    'ajax_delivery_delivered'
];

if (in_array($page, $ajaxRoutes)) {
    header('Content-Type: application/json');
}

switch ($page) {

    
    case 'home':
        beverageController_home($conn);
        break;

    case 'beverages':
        beverageController_listing($conn);
        break;

    case 'ajax_beverage_search':
        beverageController_ajaxSearch($conn);
        break;

    case 'beverage_details':
        beverageController_details($conn);
        break;

    case 'about':
        require __DIR__ . '/views/customer/about.php';
        break;

    case 'contact':
        require __DIR__ . '/views/customer/contact.php';
        break;

    // ---------------- Auth ----------------
    case 'login':
        authController_login($conn);
        break;

    case 'register':
        authController_register($conn);
        break;

    case 'logout':
        authController_logout();
        break;

   
    case 'cart':
        cartController_view($conn);
        break;

    case 'ajax_cart_add':
        cartController_ajaxAdd($conn);
        break;

    case 'ajax_cart_update':
        cartController_ajaxUpdate($conn);
        break;

    case 'ajax_cart_remove':
        cartController_ajaxRemove($conn);
        break;


    case 'checkout':
        orderController_checkout($conn);
        break;

    case 'order_success':
        orderController_success($conn);
        break;

    case 'track_order':
        orderController_track($conn);
        break;

    case 'cancel_order':
        orderController_cancel($conn);
        break;

    
    case 'customer_dashboard':
        customerController_dashboard($conn);
        break;

    case 'order_history':
        customerController_orderHistory($conn);
        break;

    case 'profile':
        customerController_profile($conn);
        break;

    case 'change_password':
        customerController_changePassword($conn);
        break;

   
    case 'admin_dashboard':
        adminController_dashboard($conn);
        break;

    case 'admin_beverages':
        adminController_beverages($conn);
        break;

    case 'admin_beverage_save':
        adminController_saveBeverage($conn);
        break;

    case 'admin_beverage_delete':
        adminController_deleteBeverage($conn);
        break;

    case 'admin_categories':
        adminController_categories($conn);
        break;

    case 'admin_category_save':
        adminController_saveCategory($conn);
        break;

    case 'admin_category_delete':
        adminController_deleteCategory($conn);
        break;

    case 'admin_orders':
        adminController_orders($conn);
        break;

    case 'ajax_order_status_update':
        adminController_ajaxUpdateOrderStatus($conn);
        break;

    case 'admin_assign_delivery':
        adminController_assignDelivery($conn);
        break;

    case 'admin_customers':
        adminController_customers($conn);
        break;

    case 'admin_delivery_personnel':
        adminController_deliveryPersonnel($conn);
        break;

   
    case 'delivery_dashboard':
        deliveryController_dashboard($conn);
        break;

    case 'delivery_order_details':
        deliveryController_orderDetails($conn);
        break;

    case 'ajax_delivery_pickup':
        deliveryController_ajaxPickup($conn);
        break;

    case 'ajax_delivery_delivered':
        deliveryController_ajaxDelivered($conn);
        break;


    default:
        http_response_code(404);
        echo "<h2 style='font-family:sans-serif;text-align:center;margin-top:80px;'>Page not found</h2>";
        break;
}
