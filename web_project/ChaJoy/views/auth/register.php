<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="form-card">
            <h2>Create Your Account</h2>
            <p class="form-subtitle">Join ChaJoy and start ordering today</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul><?php foreach ($errors as $err) echo "<li>" . clean($err) . "</li>"; ?></ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=register" id="regForm">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" id="full_name"
                        value="<?php echo clean($old['fullName'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="reg_email" value="<?php echo clean($old['email']); ?>" required>
                    <span id="email_msg" style="color:#E15252; font-size:0.8rem;"></span>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="<?php echo clean($old['phone']); ?>" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" minlength="6" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" minlength="6" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="2" required><?php echo clean($old['address']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>

            <div class="form-footer">
                Already have an account? <a href="index.php?page=login">Login here</a>
            </div>
        </div>
    </div>
</section>

<script>
    // Simple client-side password match check (server also validates)
    document.getElementById('regForm').addEventListener('submit', function(e) {
        var pass = this.password.value;
        var confirm = this.confirm_password.value;
        if (pass !== confirm) {
            alert('Password and Confirm Password do not match.');
            e.preventDefault();
        }
    });
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>