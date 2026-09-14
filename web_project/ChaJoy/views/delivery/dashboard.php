<?php $deliveryPageTitle = 'Dashboard'; require __DIR__ . '/../layouts/delivery_header.php'; ?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-value"><?php echo count($assignedOrders); ?></div>
        <div class="stat-label">Assigned Orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🚴</div>
        <div class="stat-value"><?php echo count($pendingDeliveries); ?></div>
        <div class="stat-label">Pending Deliveries</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-value"><?php echo count($completedDeliveries); ?></div>
        <div class="stat-label">Completed Deliveries</div>
    </div>
</div>

<div class="card">
    <h3>My Assigned Orders</h3>
    <?php if (empty($assignedOrders)): ?>
        <p style="color:#7d6a58;">No orders assigned to you yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Order ID</th><th>Customer</th><th>Phone</th><th>Address</th><th>Total</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($assignedOrders as $o): ?>
                        <tr>
                            <td><a href="index.php?page=delivery_order_details&id=<?php echo $o['id']; ?>"><?php echo clean($o['order_code']); ?></a></td>
                            <td><?php echo clean($o['full_name']); ?></td>
                            <td><?php echo clean($o['phone']); ?></td>
                            <td><?php echo clean($o['address']); ?></td>
                            <td><?php echo formatMoney($o['total']); ?></td>
                            <td><span class="status status-<?php echo str_replace(' ', '-', $o['status']); ?>" id="statusBadge_<?php echo $o['id']; ?>"><?php echo $o['status']; ?></span></td>
                            <td>
                                <button class="btn btn-outline btn-sm pickup-btn" data-order-id="<?php echo $o['id']; ?>"
                                    style="<?php echo $o['status'] !== 'Ready for Pickup' ? 'display:none;' : ''; ?>">Pick Up Order</button>
                                <button class="btn btn-primary btn-sm delivered-btn" data-order-id="<?php echo $o['id']; ?>"
                                    style="<?php echo $o['status'] !== 'Out for Delivery' ? 'display:none;' : ''; ?>">Mark as Delivered</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/delivery_footer.php'; ?>
