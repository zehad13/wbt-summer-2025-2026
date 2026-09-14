<?php $adminPageTitle = 'Dashboard'; require __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-value"><?php echo $todaysOrders; ?></div>
        <div class="stat-label">Today's Orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value"><?php echo $totalCustomers; ?></div>
        <div class="stat-label">Total Customers</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🥤</div>
        <div class="stat-value"><?php echo $availableBeverages; ?></div>
        <div class="stat-label">Available Beverages</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⚠️</div>
        <div class="stat-value"><?php echo $lowStockItems; ?></div>
        <div class="stat-label">Low Stock Items</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-value"><?php echo formatMoney($todaysSales); ?></div>
        <div class="stat-label">Today's Sales</div>
    </div>
</div>

<div class="card">
    <h3>Recent Orders</h3>
    <?php if (empty($recentOrders)): ?>
        <p style="color:#7d6a58;">No orders yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Order ID</th><th>Date</th><th>Total</th><th>Payment</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($recentOrders as $o): ?>
                        <tr>
                            <td><?php echo clean($o['order_code']); ?></td>
                            <td><?php echo date('d M Y, h:i A', strtotime($o['created_at'])); ?></td>
                            <td><?php echo formatMoney($o['total']); ?></td>
                            <td><?php echo clean($o['payment_method']); ?></td>
                            <td><span class="status status-<?php echo str_replace(' ', '-', $o['status']); ?>"><?php echo $o['status']; ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/admin_footer.php'; ?>
