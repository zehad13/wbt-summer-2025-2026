<?php

function createDeliveryRecord($conn, $orderId)
{
    $stmt = $conn->prepare(
        "INSERT INTO deliveries (order_id, status)
         VALUES (?, 'Waiting')"
    );

    $stmt->bind_param("i", $orderId);

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function findDeliveryByOrder($conn, $orderId)
{
    $stmt = $conn->prepare(
        "SELECT * FROM deliveries
         WHERE order_id = ?
         LIMIT 1"
    );

    $stmt->bind_param("i", $orderId);

    $stmt->execute();

    $delivery = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return $delivery;
}


function markPickedUp($conn, $orderId, $deliveryPersonId)
{
    $stmt = $conn->prepare(
        "UPDATE deliveries
         SET delivery_person_id = ?,
             status = 'Picked Up',
             picked_up_at = NOW()
         WHERE order_id = ?"
    );

    $stmt->bind_param(
        "ii",
        $deliveryPersonId,
        $orderId
    );

    $success = $stmt->execute();

    $stmt->close();

    updateOrderStatus(
        $conn,
        $orderId,
        'Out for Delivery'
    );

    return $success;
}


function markDelivered($conn, $orderId)
{
    $stmt = $conn->prepare(
        "UPDATE deliveries
         SET status = 'Delivered',
             delivered_at = NOW()
         WHERE order_id = ?"
    );

    $stmt->bind_param("i", $orderId);

    $success = $stmt->execute();

    $stmt->close();

    updateOrderStatus(
        $conn,
        $orderId,
        'Delivered'
    );

    return $success;
}


function countCompletedDeliveries($conn, $deliveryPersonId)
{
    $stmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM deliveries
         WHERE delivery_person_id = ?
         AND status = 'Delivered'"
    );

    $stmt->bind_param(
        "i",
        $deliveryPersonId
    );

    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return (int)$row['total'];
}

?>