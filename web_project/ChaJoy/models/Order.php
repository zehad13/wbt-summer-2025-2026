<?php

function createOrder($conn, $userId, $fullName, $phone, $address, $paymentMethod, $subtotal, $deliveryCharge, $total)
{
    $orderCode = generateOrderId();

    $stmt = $conn->prepare(
        "INSERT INTO orders
        (order_code, user_id, full_name, phone, address, payment_method,
         subtotal, delivery_charge, total, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')"
    );

    $stmt->bind_param(
        "sissssddd",
        $orderCode,
        $userId,
        $fullName,
        $phone,
        $address,
        $paymentMethod,
        $subtotal,
        $deliveryCharge,
        $total
    );

    $stmt->execute();

    $orderId = $conn->insert_id;

    $stmt->close();

    return [
        'id' => $orderId,
        'code' => $orderCode
    ];
}


function addOrderItem($conn, $orderId, $beverageId, $name, $price, $qty)
{
    $subtotal = $price * $qty;

    $stmt = $conn->prepare(
        "INSERT INTO order_items
        (order_id, beverage_id, beverage_name, price, quantity, subtotal)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "iisdid",
        $orderId,
        $beverageId,
        $name,
        $price,
        $qty,
        $subtotal
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


// Get order items

function getOrderItems($conn, $orderId)
{
    $stmt = $conn->prepare(
        "SELECT * FROM order_items
         WHERE order_id = ?"
    );

    $stmt->bind_param("i", $orderId);

    $stmt->execute();

    $result = $stmt->get_result();

    $items = [];

    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();

    return $items;
}



function findOrderById($conn, $orderId)
{
    $stmt = $conn->prepare(
        "SELECT * FROM orders
         WHERE id = ?
         LIMIT 1"
    );

    $stmt->bind_param("i", $orderId);

    $stmt->execute();

    $order = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return $order;
}


function findOrderByCode($conn, $code)
{
    $stmt = $conn->prepare(
        "SELECT * FROM orders
         WHERE order_code = ?
         LIMIT 1"
    );

    $stmt->bind_param("s", $code);

    $stmt->execute();

    $order = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return $order;
}


function getOrdersByUser($conn, $userId)
{
    $stmt = $conn->prepare(
        "SELECT * FROM orders
         WHERE user_id = ?
         ORDER BY created_at DESC"
    );

    $stmt->bind_param("i", $userId);

    $stmt->execute();

    $result = $stmt->get_result();

    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();

    return $orders;
}


function getAllOrders($conn)
{
    $sql = "SELECT o.*, d.full_name AS delivery_name
            FROM orders o
            LEFT JOIN users d
            ON o.assigned_delivery_id = d.id
            ORDER BY o.created_at DESC";

    $result = $conn->query($sql);

    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}


function getOrdersAssignedToDelivery($conn, $deliveryId)
{
    $stmt = $conn->prepare(
        "SELECT * FROM orders
         WHERE assigned_delivery_id = ?
         ORDER BY created_at DESC"
    );

    $stmt->bind_param("i", $deliveryId);

    $stmt->execute();

    $result = $stmt->get_result();

    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();

    return $orders;
}


function updateOrderStatus($conn, $orderId, $status)
{
    $stmt = $conn->prepare(
        "UPDATE orders
         SET status = ?
         WHERE id = ?"
    );

    $stmt->bind_param("si", $status, $orderId);

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}

 

function assignDeliveryPerson($conn, $orderId, $deliveryId)
{
    $stmt = $conn->prepare(
        "UPDATE orders
         SET assigned_delivery_id = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ii",
        $deliveryId,
        $orderId
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function cancelOrder($conn, $orderId, $userId)
{
    $stmt = $conn->prepare(
        "UPDATE orders
         SET status = 'Cancelled'
         WHERE id = ?
         AND user_id = ?
         AND status IN ('Pending', 'Preparing')"
    );

    $stmt->bind_param(
        "ii",
        $orderId,
        $userId
    );

    $success = $stmt->execute();

    $affected = $stmt->affected_rows;

    $stmt->close();

    return $affected > 0;
}




function canCancelOrder($order)
{
    return in_array(
        $order['status'],
        ['Pending', 'Preparing']
    );
}



function countOrdersByStatus($conn, $status)
{
    $stmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM orders
         WHERE status = ?"
    );

    $stmt->bind_param("s", $status);

    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return (int)$row['total'];
}




function countTodayOrders($conn)
{
    $result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM orders
         WHERE DATE(created_at) = CURDATE()"
    );

    return (int)$result->fetch_assoc()['total'];
}




function sumTodaySales($conn)
{
    $result = $conn->query(
        "SELECT COALESCE(SUM(total), 0) AS total
         FROM orders
         WHERE DATE(created_at) = CURDATE()
         AND status != 'Cancelled'"
    );

    return (float)$result->fetch_assoc()['total'];
}




function countOrdersForCustomer($conn, $userId, $statuses = null)
{
    if ($statuses === null) {

        $stmt = $conn->prepare(
            "SELECT COUNT(*) AS total
             FROM orders
             WHERE user_id = ?"
        );

        $stmt->bind_param("i", $userId);

    } else {

        $placeholders = implode(
            ",",
            array_fill(0, count($statuses), "?")
        );

        $types = "i" . str_repeat(
            "s",
            count($statuses)
        );

        $stmt = $conn->prepare(
            "SELECT COUNT(*) AS total
             FROM orders
             WHERE user_id = ?
             AND status IN ($placeholders)"
        );

        $stmt->bind_param(
            $types,
            $userId,
            ...$statuses
        );
    }

    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return (int)$row['total'];
}

?>