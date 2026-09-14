<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="form-card">

            <h2>Welcome Back</h2>
            <p class="form-subtitle">Login to your ChaJoy account</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $err) echo "<li>" . clean($err) . "</li>"; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=login">

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email"
                           value="<?php echo $_POST['email'] ?? ''; ?>"
                           required autofocus>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Login
                </button>

            </form>

            <div class="form-footer">
                Don't have an account?
                <a href="index.php?page=register">Register here</a>
            </div>

        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
