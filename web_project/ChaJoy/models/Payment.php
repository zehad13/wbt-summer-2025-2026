<?php

function createPayment($conn, $orderId, $method, $amount)
{
    if ($method === 'Online') {
        $status = 'Paid';
        $paidAt = date('Y-m-d H:i:s');
    } else {
        $status = 'Pending';
        $paidAt = null;
    }

    $stmt = $conn->prepare(
        "INSERT INTO payments
        (order_id, method, amount, status, paid_at)
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "isdss",
        $orderId,
        $method,
        $amount,
        $status,
        $paidAt
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function findPaymentByOrder($conn, $orderId)
{
    $stmt = $conn->prepare(
        "SELECT * FROM payments
         WHERE order_id = ?
         LIMIT 1"
    );

    $stmt->bind_param("i", $orderId);

    $stmt->execute();

    $payment = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return $payment;
}

?>