<?php $deliveryPageTitle = 'Order Details'; require __DIR__ . '/../layouts/delivery_header.php'; ?>

<div class="card">
    <h3>Order <?php echo clean($order['order_code']); ?></h3>
    <p><strong>Customer:</strong> <?php echo clean($order['full_name']); ?></p>
    <p><strong>Phone:</strong> <?php echo clean($order['phone']); ?></p>
    <p><strong>Delivery Address:</strong> <?php echo clean($order['address']); ?></p>
    <p><strong>Payment Method:</strong> <?php echo clean($order['payment_method']); ?></p>
    <p><strong>Status:</strong> <span class="status status-<?php echo str_replace(' ', '-', $order['status']); ?>" id="statusBadge_<?php echo $order['id']; ?>"><?php echo $order['status']; ?></span></p>

    <h3 class="mt-2">Order Items</h3>
    <?php foreach ($orderItems as $item): ?>
        <div class="summary-row">
            <span><?php echo clean($item['beverage_name']); ?> x<?php echo $item['quantity']; ?></span>
            <span><?php echo formatMoney($item['subtotal']); ?></span>
        </div>
    <?php endforeach; ?>
    <div class="summary-row total"><span>Total</span><span><?php echo formatMoney($order['total']); ?></span></div>

    <div class="mt-2">
        <button class="btn btn-outline pickup-btn" data-order-id="<?php echo $order['id']; ?>"
            style="<?php echo $order['status'] !== 'Ready for Pickup' ? 'display:none;' : ''; ?>">Pick Up Order</button>
        <button class="btn btn-primary delivered-btn" data-order-id="<?php echo $order['id']; ?>"
            style="<?php echo $order['status'] !== 'Out for Delivery' ? 'display:none;' : ''; ?>">Mark as Delivered</button>
        <a href="index.php?page=delivery_dashboard" class="btn btn-outline">Back to Dashboard</a>
    </div>
</div>

<?php require __DIR__ . '/../layouts/delivery_footer.php'; ?>
