<?php
$cartCount = 0;
if (isLoggedIn() && currentRole() === 'customer') {
    $cartCount = getCartItemCount($conn, $_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChaJoy - Your Favorite Drinks, Just a Click Away!</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<header class="navbar">
    <div class="container navbar-inner">
        <a href="index.php?page=home" class="logo">Cha<span>Joy</span></a>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">&#9776;</button>

        <nav class="nav-links" id="navLinks">
            <a href="index.php?page=home">Home</a>
            <a href="index.php?page=beverages">Beverages</a>
            <a href="index.php?page=beverages">Categories</a>
            <a href="index.php?page=about">About</a>
            <a href="index.php?page=contact">Contact</a>
        </nav>

        <div class="nav-actions">
            <a href="index.php?page=cart" class="icon-btn cart-icon" title="Cart">
                🛒 <span class="cart-badge" id="cartBadge"><?php echo $cartCount; ?></span>
            </a>

            <?php if (isLoggedIn()): ?>
                <div class="dropdown">
                    <button class="btn btn-outline dropdown-toggle">👤 <?php echo clean($_SESSION['user_name']); ?></button>
                    <div class="dropdown-menu">
                        <?php if (currentRole() === 'customer'): ?>
                            <a href="index.php?page=customer_dashboard">Dashboard</a>
                            <a href="index.php?page=order_history">My Orders</a>
                            <a href="index.php?page=profile">Profile</a>
                        <?php elseif (currentRole() === 'admin'): ?>
                            <a href="index.php?page=admin_dashboard">Admin Dashboard</a>
                        <?php elseif (currentRole() === 'delivery'): ?>
                            <a href="index.php?page=delivery_dashboard">Delivery Dashboard</a>
                        <?php endif; ?>
                        <a href="index.php?page=logout">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="index.php?page=login" class="btn btn-outline">Login</a>
                <a href="index.php?page=register" class="btn btn-primary">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main>
<?php
$successMsg = flash('success');
$errorMsg = flash('error');
?>
<?php if (!empty($successMsg)): ?>
    <div class="container"><div class="alert alert-success"><?php echo $successMsg; ?></div></div>
<?php endif; ?>
<?php if (!empty($errorMsg)): ?>
    <div class="container"><div class="alert alert-error"><?php echo $errorMsg; ?></div></div>
<?php endif; ?>
