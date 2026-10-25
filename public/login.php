<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/layout.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_post_with_csrf();
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $stmt = db()->prepare('SELECT id, password_hash FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if ($row && password_verify((string) ($_POST['password'] ?? ''), $row['password_hash'])) {
        log_in((int) $row['id']);
        redirect('/');
    }
    flash('Invalid email or password.', 'danger');
    redirect('/login.php');
}

if (current_user()) {
    redirect('/');
}

page_header('Log in');
?>
<div class="narrow">
  <h1 class="h3 mb-3">Log in</h1>
  <form method="post" action="/login.php">
    <?= csrf_field() ?>
    <div class="mb-3">
      <label class="form-label" for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" autocomplete="username" required>
    </div>
    <div class="mb-3">
      <label class="form-label" for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
    </div>
    <button type="submit" class="btn btn-primary">Log in</button>
    <a class="ms-2" href="/signup.php">Create an account</a>
  </form>
</div>
<?php
page_footer();
