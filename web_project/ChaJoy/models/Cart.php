<?php

function getOrCreateCart($conn, $userId) {

    $stmt = $conn->prepare(
        "SELECT id FROM cart WHERE user_id = ? LIMIT 1"
    );

    $stmt->bind_param("i", $userId);

    $stmt->execute();

    $cart = $stmt->get_result()->fetch_assoc();

    $stmt->close();


    if ($cart) {

        return (int)$cart['id'];
    }


    $stmt = $conn->prepare(
        "INSERT INTO cart (user_id) VALUES (?)"
    );

    $stmt->bind_param("i", $userId);

    $stmt->execute();

    $newCartId = $conn->insert_id;

    $stmt->close();

    return (int)$newCartId;
}


function getCartItems($conn, $userId) {

    $cartId = getOrCreateCart(
        $conn,
        $userId
    );


    $sql = "SELECT ci.id AS cart_item_id,
                   ci.quantity,
                   b.id AS beverage_id,
                   b.name,
                   b.price,
                   b.image,
                   b.stock
            FROM cart_items ci
            JOIN beverages b ON ci.beverage_id = b.id
            WHERE ci.cart_id = ?
            ORDER BY ci.id DESC";


    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $cartId);

    $stmt->execute();

    $result = $stmt->get_result();

    $items = [];


    while ($row = $result->fetch_assoc()) {

        $row['subtotal'] =
            $row['price'] * $row['quantity'];

        $items[] = $row;
    }


    $stmt->close();

    return $items;
}


function addToCart(
    $conn,
    $userId,
    $beverageId,
    $qty = 1
) {

    $cartId = getOrCreateCart(
        $conn,
        $userId
    );


    $stmt = $conn->prepare(
        "SELECT id, quantity
         FROM cart_items
         WHERE cart_id = ?
         AND beverage_id = ?
         LIMIT 1"
    );

    $stmt->bind_param(
        "ii",
        $cartId,
        $beverageId
    );

    $stmt->execute();

    $existing = $stmt->get_result()->fetch_assoc();

    $stmt->close();


    if ($existing) {

        $newQty =
            $existing['quantity'] + $qty;


        $stmt = $conn->prepare(
            "UPDATE cart_items
             SET quantity = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "ii",
            $newQty,
            $existing['id']
        );

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO cart_items
             (cart_id, beverage_id, quantity)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "iii",
            $cartId,
            $beverageId,
            $qty
        );
    }


    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function updateCartItemQuantity(
    $conn,
    $cartItemId,
    $qty
) {

    if ($qty <= 0) {

        return removeCartItem(
            $conn,
            $cartItemId
        );
    }


    $stmt = $conn->prepare(
        "UPDATE cart_items
         SET quantity = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ii",
        $qty,
        $cartItemId
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function removeCartItem(
    $conn,
    $cartItemId
) {

    $stmt = $conn->prepare(
        "DELETE FROM cart_items WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $cartItemId
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function clearCart(
    $conn,
    $userId
) {

    $cartId = getOrCreateCart(
        $conn,
        $userId
    );


    $stmt = $conn->prepare(
        "DELETE FROM cart_items WHERE cart_id = ?"
    );

    $stmt->bind_param(
        "i",
        $cartId
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function getCartItemCount(
    $conn,
    $userId
) {

    $cartId = getOrCreateCart(
        $conn,
        $userId
    );


    $stmt = $conn->prepare(
        "SELECT COALESCE(SUM(quantity), 0) AS total
         FROM cart_items
         WHERE cart_id = ?"
    );

    $stmt->bind_param(
        "i",
        $cartId
    );

    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return (int)$row['total'];
}


function getCartTotals($items) {

    $subtotal = 0;


    foreach ($items as $item) {

        $subtotal += $item['subtotal'];
    }


    if ($subtotal > 0) {

        $deliveryCharge = DELIVERY_CHARGE;

    } else {

        $deliveryCharge = 0;
    }


    $grandTotal =
        $subtotal + $deliveryCharge;


    return [
        'subtotal' => $subtotal,
        'delivery_charge' => $deliveryCharge,
        'total' => $grandTotal
    ];
}

?>