<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Track Your Order</h2>
            <p>Order ID: <strong><?php echo clean($order['order_code']); ?></strong></p>
        </div>

        <?php if ($order['status'] === 'Cancelled'): ?>
            <div class="alert alert-error text-center">This order has been cancelled.</div>
        <?php else: ?>
            <div class="tracker">
                <?php foreach ($stages as $key => $label): ?>
                    <?php
                        $index = array_search($key, $stageKeys);
                        $state = $index < $currentIndex ? 'completed' : ($index === $currentIndex ? 'current' : '');
                    ?>
                    <div class="tracker-step <?php echo $state; ?>">
                        <div class="tracker-dot"><?php echo $index < $currentIndex ? '✓' : ($index + 1); ?></div>
                        <div class="tracker-label"><?php echo $label; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="display:flex; gap:30px; flex-wrap:wrap;">
            <div class="card" style="flex:2 1 400px;">
                <h3>Order Details</h3>
                <p><strong>Order Date:</strong> <?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
                <p><strong>Delivery Address:</strong> <?php echo clean($order['address']); ?></p>
                <p><strong>Payment Method:</strong> <?php echo clean($order['payment_method']); ?></p>
                <p><strong>Current Status:</strong> <span class="status status-<?php echo str_replace(' ', '-', $order['status']); ?>"><?php echo $order['status']; ?></span></p>

                <h3 class="mt-2">Items</h3>
                <?php foreach ($orderItems as $item): ?>
                    <div class="summary-row">
                        <span><?php echo clean($item['beverage_name']); ?> x<?php echo $item['quantity']; ?></span>
                        <span><?php echo formatMoney($item['subtotal']); ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="summary-row total"><span>Total</span><span><?php echo formatMoney($order['total']); ?></span></div>

                <?php if (canCancelOrder($order)): ?>
                    <form method="POST" action="index.php?page=cancel_order" class="mt-2" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <button type="submit" class="btn btn-danger">Cancel Order</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
