<?php $adminPageTitle = 'Order Management'; require __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="card">
    <h3>All Orders</h3>
    <?php if (empty($orders)): ?>
        <p style="color:#7d6a58;">No orders yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr><th>Order ID</th><th>Customer</th><th>Date</th><th>Total</th><th>Payment</th><th>Status</th><th>Delivery Person</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><?php echo clean($o['order_code']); ?></td>
                            <td><?php echo clean($o['full_name']); ?></td>
                            <td><?php echo date('d M Y, h:i A', strtotime($o['created_at'])); ?></td>
                            <td><?php echo formatMoney($o['total']); ?></td>
                            <td><?php echo clean($o['payment_method']); ?></td>
                            <td>
                                <span class="status status-<?php echo str_replace(' ', '-', $o['status']); ?>" id="statusBadge_<?php echo $o['id']; ?>"><?php echo $o['status']; ?></span>
                                <select class="order-status-select" data-order-id="<?php echo $o['id']; ?>" style="margin-top:6px; width:100%; padding:4px; border-radius:8px; border:1px solid #eadfce;">
                                    <?php foreach (['Pending','Preparing','Ready for Pickup','Out for Delivery','Delivered','Cancelled'] as $st): ?>
                                        <option value="<?php echo $st; ?>" <?php echo $st === $o['status'] ? 'selected' : ''; ?>><?php echo $st; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <form method="POST" action="index.php?page=admin_assign_delivery" style="display:flex; gap:6px;">
                                    <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                                    <select name="delivery_id" style="padding:6px; border-radius:8px; border:1px solid #eadfce;">
                                        <option value="0">Unassigned</option>
                                        <?php foreach ($deliveryPersonnel as $dp): ?>
                                            <option value="<?php echo $dp['id']; ?>" <?php echo (int)$o['assigned_delivery_id'] === (int)$dp['id'] ? 'selected' : ''; ?>>
                                                <?php echo clean($dp['full_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-outline btn-sm">Assign</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/admin_footer.php'; ?>
