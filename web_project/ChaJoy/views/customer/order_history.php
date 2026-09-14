<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="section-title" style="text-align:left;"><h2>My Orders</h2></div>

        <?php if (empty($orders)): ?>
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <p>You haven't placed any orders yet.</p>
                <a href="index.php?page=beverages" class="btn btn-primary mt-2">Browse Beverages</a>
            </div>
        <?php else: ?>
            <div class="card table-responsive">
                <table>
                    <thead><tr><th>Order ID</th><th>Date</th><th>Items Total</th><th>Payment</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td><?php echo clean($o['order_code']); ?></td>
                                <td><?php echo date('d M Y, h:i A', strtotime($o['created_at'])); ?></td>
                                <td><?php echo formatMoney($o['total']); ?></td>
                                <td><?php echo clean($o['payment_method']); ?></td>
                                <td><span class="status status-<?php echo str_replace(' ', '-', $o['status']); ?>"><?php echo $o['status']; ?></span></td>
                                <td><a href="index.php?page=track_order&id=<?php echo $o['id']; ?>" class="btn btn-outline btn-sm">Track</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
