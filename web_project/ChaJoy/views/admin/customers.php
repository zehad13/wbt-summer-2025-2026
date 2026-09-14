<?php $adminPageTitle = 'Customers'; require __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="card">
    <h3>All Customers</h3>
    <?php if (empty($customers)): ?>
        <p style="color:#7d6a58;">No customers registered yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Joined</th></tr></thead>
                <tbody>
                    <?php foreach ($customers as $c): ?>
                        <tr>
                            <td><?php echo clean($c['full_name']); ?></td>
                            <td><?php echo clean($c['email']); ?></td>
                            <td><?php echo clean($c['phone']); ?></td>
                            <td><?php echo clean($c['address']); ?></td>
                            <td><?php echo date('d M Y', strtotime($c['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/admin_footer.php'; ?>
