<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Checkout</h2>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul><?php foreach ($errors as $err) echo "<li>" . clean($err) . "</li>"; ?></ul>
            </div>
        <?php endif; ?>

        <div style="display:flex; gap:30px; flex-wrap:wrap;">
            <div class="card" style="flex:2 1 400px;">
                <h3>Delivery Information</h3>
                <form method="POST" action="index.php?page=checkout">
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="full_name" value="<?php echo clean($_POST['full_name'] ?? $user['full_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?php echo clean($_POST['phone'] ?? $user['phone']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Delivery Address</label>
                        <textarea name="address" rows="3" required><?php echo clean($_POST['address'] ?? $user['address']); ?></textarea>
                    </div>

                    <h3 class="mt-2">Payment Method</h3>
                    <div class="form-group">
                        <label><input type="radio" name="payment_method" value="COD" checked style="width:auto;"> Cash on Delivery</label><br>
                        <label><input type="radio" name="payment_method" value="Online" style="width:auto;"> Online Payment</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                </form>
            </div>

            <div class="card" style="flex:1 1 280px; align-self: flex-start;">
                <h3>Order Summary</h3>
                <?php foreach ($items as $item): ?>
                    <div class="summary-row">
                        <span><?php echo clean($item['name']); ?> x<?php echo $item['quantity']; ?></span>
                        <span><?php echo formatMoney($item['subtotal']); ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="summary-row"><span>Subtotal</span><span><?php echo formatMoney($totals['subtotal']); ?></span></div>
                <div class="summary-row"><span>Delivery Charge</span><span><?php echo formatMoney($totals['delivery_charge']); ?></span></div>
                <div class="summary-row total"><span>Total</span><span><?php echo formatMoney($totals['total']); ?></span></div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
