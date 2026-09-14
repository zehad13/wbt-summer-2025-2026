<?php

// Delivery Dashboard

function deliveryController_dashboard($conn) {

    requireRole('delivery');

    $deliveryId = $_SESSION['user_id'];

    $assignedOrders = getOrdersAssignedToDelivery(
        $conn,
        $deliveryId
    );


    $pendingDeliveries = array_filter(
        $assignedOrders,
        function ($o) {
            return in_array(
                $o['status'],
                ['Ready for Pickup', 'Out for Delivery']
            );
        }
    );


    $completedDeliveries = array_filter(
        $assignedOrders,
        function ($o) {
            return $o['status'] === 'Delivered';
        }
    );


    require __DIR__ . '/../views/delivery/dashboard.php';
}


// Order Details

function deliveryController_orderDetails($conn) {

    requireRole('delivery');

    $orderId = (int)($_GET['id'] ?? 0);

    $order = findOrderById($conn, $orderId);


    if (
        !$order ||
        (int)$order['assigned_delivery_id'] !== (int)$_SESSION['user_id']
    ) {

        flash(
            'error',
            "This order is not assigned to you."
        );

        redirect(
            'index.php?page=delivery_dashboard'
        );
    }


    $orderItems = getOrderItems(
        $conn,
        $orderId
    );


    require __DIR__ . '/../views/delivery/order_details.php';
}


// Pickup Order

function deliveryController_ajaxPickup($conn) {

    if (!isLoggedIn() || currentRole() !== 'delivery') {

        echo json_encode([
            'success' => false,
            'message' => 'Unauthorized'
        ]);

        return;
    }


    $orderId = (int)($_POST['order_id'] ?? 0);

    $order = findOrderById(
        $conn,
        $orderId
    );


    if (
        !$order ||
        (int)$order['assigned_delivery_id'] !== (int)$_SESSION['user_id']
    ) {

        echo json_encode([
            'success' => false,
            'message' => 'This order is not assigned to you.'
        ]);

        return;
    }


    markPickedUp(
        $conn,
        $orderId,
        $_SESSION['user_id']
    );


    echo json_encode([
        'success' => true,
        'message' => 'Order marked as picked up.',
        'status' => 'Out for Delivery'
    ]);
}


// Mark Order as Delivered

function deliveryController_ajaxDelivered($conn) {

    if (!isLoggedIn() || currentRole() !== 'delivery') {

        echo json_encode([
            'success' => false,
            'message' => 'Unauthorized'
        ]);

        return;
    }


    $orderId = (int)($_POST['order_id'] ?? 0);

    $order = findOrderById(
        $conn,
        $orderId
    );


    if (
        !$order ||
        (int)$order['assigned_delivery_id'] !== (int)$_SESSION['user_id']
    ) {

        echo json_encode([
            'success' => false,
            'message' => 'This order is not assigned to you.'
        ]);

        return;
    }


    markDelivered(
        $conn,
        $orderId
    );


    echo json_encode([
        'success' => true,
        'message' => 'Order marked as delivered.',
        'status' => 'Delivered'
    ]);
}

?>