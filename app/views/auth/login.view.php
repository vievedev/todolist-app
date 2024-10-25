<?php include '../app/views/inc/header.inc.php'; ?>
    <div class="row mt-3">
        <div class="col-10 col-md-6 col-lg-4 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <form action="<?=ROOT?>auth/login" method="POST">
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" value="<?= $_SESSION['login_email'] ?? ''; ?>" placeholder="Email" autocomplete="off" autofocus required>
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <a class="btn btn-link text-secondary float-start" href="<?=ROOT?>register">Register</a>
                            <button type="submit" class="btn btn-secondary float-end">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3">
                <?php if(isset($_SESSION['errors'])): ?>
                    <?php foreach($_SESSION['errors'] as $error): ?>
                    <div class="alert alert-danger text-center py-2 mb-2"><?= $error; ?></div>
                    <?php endforeach; ?>
                <?php unset($_SESSION['errors']); endif; ?>
            </div>
        </div>
    </div>
<?php include '../app/views/inc/footer.inc.php'; ?>