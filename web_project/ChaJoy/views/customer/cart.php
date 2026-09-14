<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Your Cart</h2>
        </div>

        <?php if (empty($items)): ?>
            <div class="empty-state">
                <div class="empty-icon">🛒</div>
                <p>Your cart is empty.</p>
                <a href="index.php?page=beverages" class="btn btn-primary mt-2">Browse Beverages</a>
            </div>
        <?php else: ?>
            <div class="card table-responsive">
                <table id="cartTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Beverage</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr data-item-id="<?php echo $item['cart_item_id']; ?>" data-price="<?php echo $item['price']; ?>">
                                <td><div class="cart-item-icon">🥤</div></td>

                                <td><div class="beverage-img">
    <img src="images/<?php echo $b['image']; ?>" 
         alt="<?php echo clean($b['name']); ?>">
</div></td>



                                <td><?php echo clean($item['name']); ?></td>
                                <td><?php echo formatMoney($item['price']); ?></td>
                                <td>
                                    <div class="qty-control">
                                        <button class="qty-decrease" type="button">−</button>
                                        <span class="qty-value"><?php echo $item['quantity']; ?></span>
                                        <button class="qty-increase" type="button">+</button>
                                    </div>
                                </td>
                                <td class="row-subtotal"><?php echo formatMoney($item['subtotal']); ?></td>
                                <td><button class="btn btn-danger btn-sm remove-item-btn" type="button">Remove</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="cart-summary mt-2">
                <div class="summary-row"><span>Total Items</span><span><?php echo count($items); ?></span></div>
                <div class="summary-row"><span>Subtotal</span><span id="summarySubtotal"><?php echo formatMoney($totals['subtotal']); ?></span></div>
                <div class="summary-row"><span>Delivery Charge</span><span id="summaryDelivery"><?php echo formatMoney($totals['delivery_charge']); ?></span></div>
                <div class="summary-row total"><span>Grand Total</span><span id="summaryTotal"><?php echo formatMoney($totals['total']); ?></span></div>

                <a href="index.php?page=beverages" class="btn btn-outline btn-block mt-2">Continue Shopping</a>
                <a href="index.php?page=checkout" class="btn btn-primary btn-block mt-2">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="public/js/cart.js"></script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
