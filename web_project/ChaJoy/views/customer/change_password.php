<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="form-card">
            <h2>Change Password</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error"><ul><?php foreach ($errors as $err) echo "<li>" . clean($err) . "</li>"; ?></ul></div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=change_password">
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Password</button>
            </form>

            <div class="form-footer">
                <a href="index.php?page=profile">Back to Profile</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
