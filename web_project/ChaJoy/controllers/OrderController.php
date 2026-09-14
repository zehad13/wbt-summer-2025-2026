<?php

// Checkout

function orderController_checkout($conn) {

    requireRole('customer');

    $userId = $_SESSION['user_id'];

    $items = getCartItems($conn, $userId);


    if (empty($items)) {

        flash(
            'error',
            "Your cart is empty. Add some beverages before checking out!"
        );

        redirect('index.php?page=beverages');
    }


    $totals = getCartTotals($items);

    $user = findUserById($conn, $userId);

    $errors = [];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $fullName = clean($_POST['full_name'] ?? '');

        $phone = clean($_POST['phone'] ?? '');

        $address = clean($_POST['address'] ?? '');

        $paymentMethod = ($_POST['payment_method'] ?? 'COD') === 'Online'
            ? 'Online'
            : 'COD';


        // Validation

        if ($fullName === '') {
            $errors[] = "Full name is required.";
        }

        if ($phone === '' || !isValidPhone($phone)) {
            $errors[] = "A valid phone number is required.";
        }

        if ($address === '') {
            $errors[] = "Delivery address is required.";
        }


        // Check stock

        foreach ($items as $item) {

            if ($item['quantity'] > $item['stock']) {

                $errors[] =
                    $item['name'] .
                    " only has " .
                    $item['stock'] .
                    " left in stock.";
            }
        }


        // Create order

        if (empty($errors)) {

            $order = createOrder(
                $conn,
                $userId,
                $fullName,
                $phone,
                $address,
                $paymentMethod,
                $totals['subtotal'],
                $totals['delivery_charge'],
                $totals['total']
            );


            // Add order items

            foreach ($items as $item) {

                addOrderItem(
                    $conn,
                    $order['id'],
                    $item['beverage_id'],
                    $item['name'],
                    $item['price'],
                    $item['quantity']
                );


                decreaseStock(
                    $conn,
                    $item['beverage_id'],
                    $item['quantity']
                );
            }


            // Payment and delivery

            createPayment(
                $conn,
                $order['id'],
                $paymentMethod,
                $totals['total']
            );

            createDeliveryRecord(
                $conn,
                $order['id']
            );


            // Clear cart

            clearCart(
                $conn,
                $userId
            );


            redirect(
                'index.php?page=order_success&code=' .
                urlencode($order['code'])
            );
        }
    }


    require __DIR__ . '/../views/customer/checkout.php';
}


// Order Success

function orderController_success($conn) {

    requireRole('customer');

    $code = clean($_GET['code'] ?? '');

    $order = findOrderByCode($conn, $code);


    if (
        !$order ||
        (int)$order['user_id'] !== (int)$_SESSION['user_id']
    ) {

        redirect('index.php?page=customer_dashboard');
    }


    $orderItems = getOrderItems(
        $conn,
        $order['id']
    );


    require __DIR__ . '/../views/customer/order_success.php';
}


// Track Order

function orderController_track($conn) {

    requireRole('customer');

    $orderId = (int)($_GET['id'] ?? 0);

    $order = findOrderById(
        $conn,
        $orderId
    );


    if (
        !$order ||
        (int)$order['user_id'] !== (int)$_SESSION['user_id']
    ) {

        flash(
            'error',
            "Order not found."
        );

        redirect('index.php?page=order_history');
    }


    $orderItems = getOrderItems(
        $conn,
        $order['id']
    );


    // Order stages

    $stages = [
        'Pending' => 'Order Placed',
        'Preparing' => 'Preparing',
        'Ready for Pickup' => 'Ready for Pickup',
        'Out for Delivery' => 'Out for Delivery',
        'Delivered' => 'Delivered'
    ];


    $stageKeys = array_keys($stages);

    $currentIndex = array_search(
        $order['status'],
        $stageKeys
    );


    require __DIR__ . '/../views/customer/order_tracking.php';
}


// Cancel Order

function orderController_cancel($conn) {

    requireRole('customer');

    $orderId = (int)(
        $_POST['order_id'] ??
        $_GET['id'] ??
        0
    );


    $success = cancelOrder(
        $conn,
        $orderId,
        $_SESSION['user_id']
    );


    if ($success) {

        flash(
            'success',
            "Order cancelled successfully."
        );

    } else {

        flash(
            'error',
            "This order can no longer be cancelled."
        );
    }


    redirect(
        'index.php?page=track_order&id=' .
        $orderId
    );
}

?>