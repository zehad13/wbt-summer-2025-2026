<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Our Beverages</h2>
            <p>Search or filter by category to find your perfect drink</p>
        </div>

        <div class="filter-bar">
            <input type="text" id="searchInput" placeholder="Search beverages by name..." value="<?php echo clean($keyword); ?>">

            <div class="category-pills">
                <span class="pill <?php echo $categoryId === 0 ? 'active' : ''; ?>" data-category="0">All</span>
                <?php foreach ($categories as $cat): ?>
                    <span class="pill <?php echo $categoryId === (int)$cat['id'] ? 'active' : ''; ?>" data-category="<?php echo $cat['id']; ?>">
                        <?php echo clean($cat['name']); ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="beverage-grid" id="beverageGrid" data-active-category="<?php echo $categoryId; ?>">
            <?php if (empty($beverages)): ?>
                <div class="empty-state"><div class="empty-icon">🥤</div><p>No beverages match your search.</p></div>
            <?php else: ?>
                <?php foreach ($beverages as $b): ?>
                    <?php $available = $b['is_available'] && $b['stock'] > 0; ?>
                    <div class="beverage-card">
                        <a href="index.php?page=beverage_details&id=<?php echo $b['id']; ?>">
                         <div class="beverage-img">
                           <img src="public/images/<?php echo clean($b['image']); ?>"
                             alt="<?php echo clean($b['name']); ?>">
                         </div>
                        </a>
                        <div class="beverage-body">
                            <span class="beverage-category"><?php echo clean($b['category_name']); ?></span>
                            <h3 class="beverage-name">
                                <a href="index.php?page=beverage_details&id=<?php echo $b['id']; ?>"><?php echo clean($b['name']); ?></a>
                            </h3>
                            <p class="beverage-desc"><?php echo clean(truncateText($b['description'], 70)); ?></p>
                            <span class="badge <?php echo $available ? 'badge-available' : 'badge-unavailable'; ?>">
                                <?php echo $available ? 'Available' : 'Out of stock'; ?>
                            </span>
                            <div class="beverage-price mt-2"><?php echo formatMoney($b['price']); ?></div>
                            <div class="beverage-actions">
                                <button class="btn btn-primary btn-sm add-to-cart-btn" data-id="<?php echo $b['id']; ?>" <?php echo $available ? '' : 'disabled'; ?>>Add to Cart</button>
                                <a href="index.php?page=beverage_details&id=<?php echo $b['id']; ?>" class="btn btn-outline btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="public/js/beverages.js"></script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
