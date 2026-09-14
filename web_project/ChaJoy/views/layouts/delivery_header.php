<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChaJoy Delivery</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body class="admin-body">

<div class="admin-layout">
    <aside class="sidebar sidebar-delivery">
        <div class="logo sidebar-logo">Cha<span>Joy</span></div>
        <p class="sidebar-role">Delivery Panel</p>
        <nav class="sidebar-nav">
            <a href="index.php?page=delivery_dashboard" class="<?php echo ($_GET['page'] ?? '') === 'delivery_dashboard' ? 'active' : ''; ?>">📊 Dashboard</a>
            <a href="index.php?page=logout">🚪 Logout</a>
        </nav>
    </aside>

    <div class="admin-content">
        <header class="admin-topbar">
            <h2><?php echo $deliveryPageTitle ?? 'Dashboard'; ?></h2>
            <div class="admin-user">👤 <?php echo clean($_SESSION['user_name']); ?></div>
        </header>

        <div class="admin-body-inner">
        <?php
        $successMsg = flash('success');
        $errorMsg = flash('error');
        ?>
        <?php if (!empty($successMsg)): ?><div class="alert alert-success"><?php echo $successMsg; ?></div><?php endif; ?>
        <?php if (!empty($errorMsg)): ?><div class="alert alert-error"><?php echo $errorMsg; ?></div><?php endif; ?>
