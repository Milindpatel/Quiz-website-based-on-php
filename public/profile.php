<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/layout.php';

$user = require_login();
$f = array_intersect_key($user, array_flip(['first_name', 'last_name', 'email', 'phone', 'address']));
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_post_with_csrf();
    $f = form_fields(array_keys($f));
    $newPassword = (string) ($_POST['new_password'] ?? '');
    $errors = profile_errors($f, (int) $user['id']);
    if ($newPassword !== '' && strlen($newPassword) < 8) {
        $errors[] = 'The new password must be at least 8 characters.';
    }
    if (!$errors) {
        $stmt = db()->prepare('UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, address = ? WHERE id = ?');
        $stmt->execute([$f['first_name'], $f['last_name'], strtolower($f['email']), $f['phone'], $f['address'], $user['id']]);
        if ($newPassword !== '') {
            db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([password_hash($newPassword, PASSWORD_DEFAULT), $user['id']]);
        }
        flash('Your profile was saved.');
        redirect('/profile.php');
    }
}

page_header('Profile');
?>
<div class="narrow">
  <h1 class="h3 mb-3">Your information</h1>
  <?php error_list($errors); ?>
  <form method="post" action="/profile.php">
    <?= csrf_field() ?>
    <?php require __DIR__ . '/../src/profile-fields.php'; ?>
    <div class="mb-3">
      <label class="form-label" for="new_password">New password</label>
      <input type="password" class="form-control" id="new_password" name="new_password" minlength="8" autocomplete="new-password">
      <div class="form-text">Leave blank to keep your current password.</div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a class="btn btn-outline-secondary ms-2" href="/scores.php">Show my scores</a>
  </form>
</div>
<?php
page_footer();
