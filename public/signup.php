<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/layout.php';

if (current_user()) {
    flash('You are already logged in.', 'info');
    redirect('/');
}

$f = ['first_name' => '', 'last_name' => '', 'email' => '', 'phone' => '', 'address' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_post_with_csrf();
    $f = form_fields(array_keys($f));
    $password = (string) ($_POST['password'] ?? '');
    $errors = profile_errors($f);
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if (!$errors) {
        $stmt = db()->prepare('INSERT INTO users (first_name, last_name, email, password_hash, phone, address) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$f['first_name'], $f['last_name'], strtolower($f['email']), password_hash($password, PASSWORD_DEFAULT), $f['phone'], $f['address']]);
        log_in((int) db()->lastInsertId());
        flash('Welcome to QuizoMania, ' . $f['first_name'] . '!');
        redirect('/');
    }
}

page_header('Sign up');
?>
<div class="narrow">
  <h1 class="h3 mb-3">Create your account</h1>
  <?php error_list($errors); ?>
  <form method="post" action="/signup.php">
    <?= csrf_field() ?>
    <?php require __DIR__ . '/../src/profile-fields.php'; ?>
    <div class="mb-3">
      <label class="form-label" for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" minlength="8" autocomplete="new-password" required>
      <div class="form-text">At least 8 characters.</div>
    </div>
    <button type="submit" class="btn btn-primary">Sign up</button>
  </form>
</div>
<?php
page_footer();
