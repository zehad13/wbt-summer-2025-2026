<?php

// Admin Dashboard

function adminController_dashboard($conn)
{

    requireRole('admin');

    $todaysOrders = countTodayOrders($conn);
    $totalCustomers = countUsersByRole($conn, 'customer');
    $availableBeverages = countAvailableBeverages($conn);
    $lowStockItems = countLowStockBeverages($conn, 5);
    $todaysSales = sumTodaySales($conn);

    $recentOrders = array_slice(getAllOrders($conn), 0, 8);

    require __DIR__ . '/../views/admin/dashboard.php';
}


// Beverage Management

function adminController_beverages($conn)
{

    requireRole('admin');

    $beverages = getAllBeverages($conn);
    $categories = getAllCategories($conn);

    require __DIR__ . '/../views/admin/beverages.php';
}


function adminController_saveBeverage($conn)
{

    requireRole('admin');

    $id = (int)($_POST['id'] ?? 0);
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $name = clean($_POST['name'] ?? '');
    $description = clean($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);

    $isAvailable = isset($_POST['is_available']) ? 1 : 0;

    $errors = [];

    if ($name == '') {
        $errors[] = "Beverage name is required.";
    }

    if ($categoryId <= 0) {
        $errors[] = "Please choose a category.";
    }

    if ($price <= 0) {
        $errors[] = "Price must be greater than zero.";
    }

    if ($stock < 0) {
        $errors[] = "Stock cannot be negative.";
    }


   

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {

        $ext = strtolower(
            pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
        );

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {

            $imageName = slugify($name) . '-' . time() . '.' . $ext;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                __DIR__ . '/../public/images/' . $imageName
            );
        }
    }




    if (empty($errors)) {

        if ($id > 0) {

            $success = updateBeverage(
                $conn,
                $id,
                $categoryId,
                $name,
                $description,
                $price,
                $stock,
                $isAvailable,
                $imageName
            );

            if ($success) {
                flash('success', "Beverage updated successfully.");
            } else {
                flash('error', "Failed to update beverage.");
            }
        } else {

            $success = createBeverage(
                $conn,
                $categoryId,
                $name,
                $description,
                $price,
                $imageName ?? 'default.jpg',
                $stock,
                $isAvailable
            );

            if ($success) {
                flash('success', "Beverage added successfully.");
            } else {
                flash('error', "Failed to add beverage.");
            }
        }
    } else {

        flash('error', implode(' ', $errors));
    }

    redirect('index.php?page=admin_beverages');
}


function adminController_deleteBeverage($conn)
{

    requireRole('admin');

    $id = (int)($_GET['id'] ?? 0);

    $success = deleteBeverage($conn, $id);

    if ($success) {
        flash('success', "Beverage deleted.");
    } else {
        flash('error', "Could not delete this beverage.");
    }

    redirect('index.php?page=admin_beverages');
}




function adminController_categories($conn)
{

    requireRole('admin');

    $categories = getAllCategories($conn);

    require __DIR__ . '/../views/admin/categories.php';
}


function adminController_saveCategory($conn)
{

    requireRole('admin');

    $id = (int)($_POST['id'] ?? 0);
    $name = clean($_POST['name'] ?? '');

    if ($name == '') {

        flash('error', "Category name is required.");
    } else {

        if ($id > 0) {

            updateCategory($conn, $id, $name);

            flash('success', "Category updated.");
        } else {

            createCategory($conn, $name);

            flash('success', "Category added.");
        }
    }

    redirect('index.php?page=admin_categories');
}


function adminController_deleteCategory($conn)
{

    requireRole('admin');

    $id = (int)($_GET['id'] ?? 0);

    $success = deleteCategory($conn, $id);

    if ($success) {

        flash('success', "Category deleted.");
    } else {

        flash(
            'error',
            "Cannot delete this category because it is being used by a beverage."
        );
    }

    redirect('index.php?page=admin_categories');
}




function adminController_orders($conn)
{

    requireRole('admin');

    $orders = getAllOrders($conn);
    $deliveryPersonnel = getAllDeliveryPersonnel($conn);

    require __DIR__ . '/../views/admin/orders.php';
}


function adminController_ajaxUpdateOrderStatus($conn)
{

    if (!isLoggedIn() || currentRole() != 'admin') {

        echo json_encode([
            'success' => false,
            'message' => 'Unauthorized'
        ]);

        return;
    }


    $orderId = (int)($_POST['order_id'] ?? 0);
    $status = clean($_POST['status'] ?? '');


    $validStatuses = [
        'Pending',
        'Preparing',
        'Ready for Pickup',
        'Out for Delivery',
        'Delivered',
        'Cancelled'
    ];


    if (!in_array($status, $validStatuses)) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid status.'
        ]);

        return;
    }


    $success = updateOrderStatus($conn, $orderId, $status);


    echo json_encode([
        'success' => $success,
        'message' => $success
            ? "Order status updated to $status"
            : "Could not update order.",
        'status' => $status
    ]);
}


function adminController_assignDelivery($conn)
{

    requireRole('admin');

    $orderId = (int)($_POST['order_id'] ?? 0);
    $deliveryId = (int)($_POST['delivery_id'] ?? 0);

    assignDeliveryPerson($conn, $orderId, $deliveryId);

    flash('success', "Delivery person assigned.");

    redirect('index.php?page=admin_orders');
}




function adminController_customers($conn)
{

    requireRole('admin');

    $customers = getAllCustomers($conn);

    require __DIR__ . '/../views/admin/customers.php';
}




function adminController_deliveryPersonnel($conn)
{

    requireRole('admin');

    $deliveryPersonnel = getAllDeliveryPersonnel($conn);

    require __DIR__ . '/../views/admin/delivery_personnel.php';
}
