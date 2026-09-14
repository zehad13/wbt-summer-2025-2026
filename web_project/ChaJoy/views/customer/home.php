<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="hero">
    <div class="container hero-inner">
        <div class="hero-text">
            <h1>Your Favorite Drinks, Just a Click Away!</h1>
            <p>Order delicious coffee, tea, juice and refreshing beverages from ChaJoy.</p>
            <div class="hero-buttons">
                <a href="index.php?page=beverages" class="btn btn-primary">Order Now</a>
                <a href="index.php?page=beverages" class="btn btn-outline">Explore Beverages</a>
            </div>
        </div>
        <div class="hero-image">🧋🥤🍹</div>
        
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Popular Beverages</h2>
            <p>Fan favorites, freshly made every day</p>
        </div>

        <div class="beverage-grid">
           <?php foreach (($popularBeverages ?? []) as $b): ?>
                <?php $available = $b['is_available'] && $b['stock'] > 0; ?>
                <div class="beverage-card">
                    <a href="index.php?page=beverage_details&id=<?php echo $b['id']; ?>">
                        


                        <div class="drink-icon">
                           <img src="public/images/<?php echo $b['image']; ?>"
                              alt="<?php echo $b['name']; ?>">
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
        </div>

        <div class="text-center mt-2">
            <a href="index.php?page=beverages" class="btn btn-secondary">View All Beverages</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
