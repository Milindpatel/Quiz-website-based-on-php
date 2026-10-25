<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

require_post_with_csrf();
$_SESSION = [];
session_regenerate_id(true);
flash('You are logged out.');
redirect('/');
