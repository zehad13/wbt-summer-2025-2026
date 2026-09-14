<?php $adminPageTitle = 'Delivery Personnel'; require __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="card">
    <h3>Delivery Personnel</h3>
    <?php if (empty($deliveryPersonnel)): ?>
        <p style="color:#7d6a58;">No delivery personnel added yet. Create one from phpMyAdmin with role = 'delivery', or extend this page with an add-user form.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Completed Deliveries</th></tr></thead>
                <tbody>
                    <?php foreach ($deliveryPersonnel as $dp): ?>
                        <tr>
                            <td><?php echo clean($dp['full_name']); ?></td>
                            <td><?php echo clean($dp['email']); ?></td>
                            <td><?php echo clean($dp['phone']); ?></td>
                            <td><?php echo countCompletedDeliveries($conn, $dp['id']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/admin_footer.php'; ?>
