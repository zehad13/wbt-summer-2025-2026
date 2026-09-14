<?php

// Customer Dashboard

function customerController_dashboard($conn) {

    requireRole('customer');

    $userId = $_SESSION['user_id'];

    $user = findUserById($conn, $userId);

    $totalOrders = countOrdersForCustomer($conn, $userId);

    $activeOrders = countOrdersForCustomer(
        $conn,
        $userId,
        ['Pending', 'Preparing', 'Ready for Pickup', 'Out for Delivery']
    );

    $completedOrders = countOrdersForCustomer(
        $conn,
        $userId,
        ['Delivered']
    );

    $recentOrders = array_slice(
        getOrdersByUser($conn, $userId),
        0,
        5
    );

    require __DIR__ . '/../views/customer/dashboard.php';
}


// Order History

function customerController_orderHistory($conn) {

    requireRole('customer');

    $orders = getOrdersByUser(
        $conn,
        $_SESSION['user_id']
    );

    require __DIR__ . '/../views/customer/order_history.php';
}


// Customer Profile

function customerController_profile($conn) {

    requireRole('customer');

    $userId = $_SESSION['user_id'];

    $user = findUserById($conn, $userId);

    $errors = [];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $fullName = clean($_POST['full_name'] ?? '');

        $phone = clean($_POST['phone'] ?? '');

        $address = clean($_POST['address'] ?? '');


        if ($fullName === '') {
            $errors[] = "Full name is required.";
        }

        if ($phone === '' || !isValidPhone($phone)) {
            $errors[] = "A valid phone number is required.";
        }

        if ($address === '') {
            $errors[] = "Address is required.";
        }


        if (empty($errors)) {

            updateUserProfile(
                $conn,
                $userId,
                $fullName,
                $phone,
                $address
            );

            $_SESSION['user_name'] = $fullName;

            flash('success', "Profile updated successfully.");

            redirect('index.php?page=profile');
        }


        $user = array_merge(
            $user,
            [
                'full_name' => $fullName,
                'phone' => $phone,
                'address' => $address
            ]
        );
    }


    require __DIR__ . '/../views/customer/profile.php';
}


// Change Password

function customerController_changePassword($conn) {

    requireRole('customer');

    $userId = $_SESSION['user_id'];

    $errors = [];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user = findUserById($conn, $userId);

        $current = trim($_POST['current_password'] ?? '');

        $new = trim($_POST['new_password'] ?? '');

        $confirm = trim($_POST['confirm_password'] ?? '');


        if (!password_verify($current, $user['password'])) {

            $errors[] = "Current password is incorrect.";
        }


        if (strlen($new) < 6) {

            $errors[] = "New password must be at least 6 characters.";
        }


        if ($new !== $confirm) {

            $errors[] = "New password and confirmation do not match.";
        }


        if (empty($errors)) {

            $hashedPassword = password_hash(
                $new,
                PASSWORD_DEFAULT
            );

            updateUserPassword(
                $conn,
                $userId,
                $hashedPassword
            );

            flash('success', "Password changed successfully.");

            redirect('index.php?page=profile');
        }
    }


    require __DIR__ . '/../views/customer/change_password.php';
}

?>