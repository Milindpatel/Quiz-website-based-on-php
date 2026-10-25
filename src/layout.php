<?php

declare(strict_types=1);

function page_header(string $title): void
{
    $user = current_user();
    $flash = take_flash();
    ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title) ?> · QuizoMania</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/">QuizoMania</a>
    <?php if ($user): ?>
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/profile.php">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="/scores.php">My scores</a></li>
      </ul>
      <form class="d-flex" action="/logout.php" method="post">
        <?= csrf_field() ?>
        <span class="navbar-text me-3">Hi, <?= e($user['first_name']) ?></span>
        <button type="submit" class="btn btn-outline-light btn-sm">Log out</button>
      </form>
    <?php else: ?>
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/signup.php">New user</a></li>
      </ul>
      <form class="d-flex gap-2" action="/login.php" method="post">
        <?= csrf_field() ?>
        <input type="email" class="form-control form-control-sm" name="email" placeholder="Email" autocomplete="username" required>
        <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" autocomplete="current-password" required>
        <button type="submit" class="btn btn-primary btn-sm">Log in</button>
      </form>
    <?php endif; ?>
  </div>
</nav>
<main class="container">
  <?php if ($flash): ?>
    <div class="alert alert-<?= e($flash['kind']) ?>"><?= e($flash['message']) ?></div>
  <?php endif; ?>
    <?php
}

function page_footer(): void
{
    ?>
</main>
<footer class="site-footer text-center">&copy; Oxygen (Milind Patel)</footer>
</body>
</html>
    <?php
}

/** Shows a list of validation errors. */
function error_list(array $errors): void
{
    foreach ($errors as $error) {
        echo '<div class="alert alert-danger">' . e($error) . "</div>\n";
    }
}
