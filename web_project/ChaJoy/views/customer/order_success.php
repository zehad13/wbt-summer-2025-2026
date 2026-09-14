<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="card text-center" style="max-width:560px; margin:0 auto;">
            <div style="font-size:4rem;">✅</div>
            <h2>Your order has been placed successfully!</h2>
            <p style="color:#7d6a58;">Order ID: <strong><?php echo clean($order['order_code']); ?></strong></p>

            <div class="text-center mt-2" style="text-align:left;">
                <?php foreach ($orderItems as $item): ?>
                    <div class="summary-row">
                        <span><?php echo clean($item['beverage_name']); ?> x<?php echo $item['quantity']; ?></span>
                        <span><?php echo formatMoney($item['subtotal']); ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="summary-row total"><span>Total Paid</span><span><?php echo formatMoney($order['total']); ?></span></div>
            </div>

            <div class="mt-2">
                <a href="index.php?page=track_order&id=<?php echo $order['id']; ?>" class="btn btn-primary">Track Order</a>
                <a href="index.php?page=beverages" class="btn btn-outline">Continue Shopping</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
