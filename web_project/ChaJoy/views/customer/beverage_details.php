<?php require __DIR__ . '/../layouts/header.php'; ?>

<?php $available = $beverage['is_available'] && $beverage['stock'] > 0; ?>

<section class="section">
    <div class="container">
        <div class="card" style="display:flex; gap:36px; flex-wrap:wrap;">
            <div style="flex:1 1 320px;">
                <div class="beverage-img" style="height:320px; border-radius:var(--radius);">
                        <img src="public/images/<?php echo clean($beverage['image']); ?>" alt="<?php echo clean($beverage['name']); ?>" style="width:100%; height:100%; object-fit:cover; border-radius:var(--radius);">
                </div>
            </div>
            <div style="flex:1 1 320px;">
                <span class="beverage-category"><?php echo clean($beverage['category_name']); ?></span>
                <h1 class="mt-2"><?php echo clean($beverage['name']); ?></h1>
                <p style="color:#7d6a58;"><?php echo clean($beverage['description']); ?></p>

                <div class="beverage-price" style="font-size:1.6rem;"><?php echo formatMoney($beverage['price']); ?></div>

                <p>
                    <span class="badge <?php echo $available ? 'badge-available' : 'badge-unavailable'; ?>">
                        <?php echo $available ? 'Available' : 'Out of stock'; ?>
                    </span>
                    <?php if ($available): ?>
                        <span style="color:#7d6a58; font-size:0.85rem; margin-left:8px;"><?php echo (int)$beverage['stock']; ?> left in stock</span>
                    <?php endif; ?>
                </p>

                <?php if ($available): ?>
                    <div class="form-group" style="max-width:140px;">
                        <label>Quantity</label>
                        <input type="number" id="qty_<?php echo $beverage['id']; ?>" value="1" min="1" max="<?php echo (int)$beverage['stock']; ?>">
                    </div>
                <?php endif; ?>

                <div class="beverage-actions mt-2">
                    <button class="btn btn-primary add-to-cart-btn" data-id="<?php echo $beverage['id']; ?>" <?php echo $available ? '' : 'disabled'; ?>>
                        <?php echo $available ? 'Add to Cart' : 'Unavailable'; ?>
                    </button>
                    <a href="index.php?page=beverages" class="btn btn-outline">Back to Beverages</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
