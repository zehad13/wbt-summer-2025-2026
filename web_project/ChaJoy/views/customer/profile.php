<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="form-card">
            <h2>My Profile</h2>
            <p class="form-subtitle">Update your personal information</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error"><ul><?php foreach ($errors as $err) echo "<li>" . clean($err) . "</li>"; ?></ul></div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=profile">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo clean($user['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="<?php echo clean($user['email']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="<?php echo clean($user['phone']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="3" required><?php echo clean($user['address']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
            </form>

            <div class="form-footer">
                <a href="index.php?page=change_password">Change Password</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
