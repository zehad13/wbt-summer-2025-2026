<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="section-title" style="text-align:left;">
            <h2>Welcome back, <?php echo clean($user['full_name']); ?>! 👋</h2>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-value"><?php echo $totalOrders; ?></div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🚴</div>
                <div class="stat-value"><?php echo $activeOrders; ?></div>
                <div class="stat-label">Active Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value"><?php echo $completedOrders; ?></div>
                <div class="stat-label">Completed Orders</div>
            </div>
        </div>

        <div style="display:flex; gap:30px; flex-wrap:wrap;">
            <div class="card" style="flex:2 1 400px;">
                <h3>Recent Orders</h3>
                <?php if (empty($recentOrders)): ?>
                    <p style="color:#7d6a58;">You haven't placed any orders yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table>
                            <thead><tr><th>Order ID</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                <?php foreach ($recentOrders as $o): ?>
                                    <tr>
                                        <td><?php echo clean($o['order_code']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($o['created_at'])); ?></td>
                                        <td><?php echo formatMoney($o['total']); ?></td>
                                        <td><span class="status status-<?php echo str_replace(' ', '-', $o['status']); ?>"><?php echo $o['status']; ?></span></td>
                                        <td><a href="index.php?page=track_order&id=<?php echo $o['id']; ?>" class="btn btn-outline btn-sm">Track</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card" style="flex:1 1 260px; align-self:flex-start;">
                <h3>Quick Links</h3>
                <a href="index.php?page=order_history" class="btn btn-outline btn-block mt-2">Order History</a>
                <a href="index.php?page=profile" class="btn btn-outline btn-block mt-2">Profile</a>
                <a href="index.php?page=change_password" class="btn btn-outline btn-block mt-2">Change Password</a>
                <a href="index.php?page=beverages" class="btn btn-primary btn-block mt-2">Order Now</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
