<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/layout.php';

$user = require_login();
$stmt = db()->prepare('SELECT subject, score, total, taken_at FROM scores WHERE user_id = ? ORDER BY id');
$stmt->execute([$user['id']]);
$bySubject = array_fill_keys(array_keys(SUBJECTS), []);
foreach ($stmt as $row) {
    $bySubject[$row['subject']][] = $row;
}

page_header('My scores');
?>
<h1 class="h3 mb-3">My scores</h1>
<?php foreach (SUBJECTS as $slug => $subject):
    $attempts = $bySubject[$slug]; ?>
  <h2 class="h5 mt-4"><?= e($subject['name']) ?></h2>
  <?php if (!$attempts): ?>
    <p class="text-body-secondary">No attempts yet. <a href="/quiz.php?subject=<?= e($slug) ?>">Take the <?= e($subject['name']) ?> quiz</a>.</p>
  <?php else: ?>
    <table class="table table-sm">
      <thead><tr><th>Attempt</th><th>Date (UTC)</th><th>Score</th></tr></thead>
      <tbody>
        <?php foreach ($attempts as $i => $a): ?>
          <tr><td><?= $i + 1 ?></td><td><?= e($a['taken_at']) ?></td><td><?= (int) $a['score'] ?> / <?= (int) $a['total'] ?></td></tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th>Total attempts: <?= count($attempts) ?></th>
          <th></th>
          <th>Best: <?= max(array_column($attempts, 'score')) ?> / <?= (int) $attempts[0]['total'] ?></th>
        </tr>
      </tfoot>
    </table>
  <?php endif; ?>
<?php endforeach; ?>
<?php
page_footer();
