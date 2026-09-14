<?php

// Cart View

function cartController_view($conn) {

    requireRole('customer');

    $items = getCartItems($conn, $_SESSION['user_id']);

    $totals = getCartTotals($items);

    require __DIR__ . '/../views/customer/cart.php';
}


// Add Item to Cart

function cartController_ajaxAdd($conn) {

    if (!isLoggedIn()) {

        echo json_encode([
            'success' => false,
            'message' => 'Please log in to add items to your cart.'
        ]);

        return;
    }


    if (currentRole() !== 'customer') {

        echo json_encode([
            'success' => false,
            'message' => 'Only customer accounts can order beverages.'
        ]);

        return;
    }


    $beverageId = (int)($_POST['beverage_id'] ?? 0);

    $qty = max(1, (int)($_POST['quantity'] ?? 1));

    $beverage = findBeverageById($conn, $beverageId);


    if (!$beverage) {

        echo json_encode([
            'success' => false,
            'message' => 'Beverage not found.'
        ]);

        return;
    }


    if (!$beverage['is_available'] || $beverage['stock'] < 1) {

        echo json_encode([
            'success' => false,
            'message' => 'This beverage is currently unavailable.'
        ]);

        return;
    }


    addToCart(
        $conn,
        $_SESSION['user_id'],
        $beverageId,
        $qty
    );


    $count = getCartItemCount(
        $conn,
        $_SESSION['user_id']
    );


    echo json_encode([
        'success' => true,
        'message' => $beverage['name'] . ' added to cart.',
        'cart_count' => $count
    ]);
}


// Update Cart

function cartController_ajaxUpdate($conn) {

    if (!isLoggedIn() || currentRole() !== 'customer') {

        echo json_encode([
            'success' => false,
            'message' => 'You must be logged in as a customer.'
        ]);

        return;
    }


    $cartItemId = (int)($_POST['cart_item_id'] ?? 0);

    $qty = (int)($_POST['quantity'] ?? 1);


    updateCartItemQuantity(
        $conn,
        $cartItemId,
        $qty
    );


    $items = getCartItems(
        $conn,
        $_SESSION['user_id']
    );

    $totals = getCartTotals($items);

    $count = getCartItemCount(
        $conn,
        $_SESSION['user_id']
    );


    echo json_encode([
        'success' => true,
        'message' => 'Cart updated successfully',
        'totals' => $totals,
        'cart_count' => $count
    ]);
}


// Remove Item from Cart

function cartController_ajaxRemove($conn) {

    if (!isLoggedIn() || currentRole() !== 'customer') {

        echo json_encode([
            'success' => false,
            'message' => 'You must be logged in as a customer.'
        ]);

        return;
    }


    $cartItemId = (int)($_POST['cart_item_id'] ?? 0);


    removeCartItem(
        $conn,
        $cartItemId
    );


    $items = getCartItems(
        $conn,
        $_SESSION['user_id']
    );

    $totals = getCartTotals($items);

    $count = getCartItemCount(
        $conn,
        $_SESSION['user_id']
    );


    echo json_encode([
        'success' => true,
        'message' => 'Item removed from cart',
        'totals' => $totals,
        'cart_count' => $count
    ]);
}

?>