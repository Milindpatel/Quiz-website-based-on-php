<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/layout.php';

page_header('Home');
?>
<h1 class="display-6 text-center mb-4">QuizoMania</h1>
<div class="row g-4">
  <?php foreach (SUBJECTS as $slug => $subject): ?>
    <div class="col-md-6 text-center">
      <h2 class="h4"><?= e($subject['tagline']) ?></h2>
      <img src="/img/<?= e($slug) ?>.jpg" alt="<?= e($subject['name']) ?>" class="img-fluid rounded mb-3 subject-img">
      <div>
        <a class="btn btn-outline-primary btn-lg" href="<?= e($subject['learn']) ?>" rel="noopener" target="_blank">Learn <?= e($subject['name']) ?></a>
        <a class="btn btn-primary btn-lg" href="/quiz.php?subject=<?= e($slug) ?>">Start <?= e($subject['name']) ?> quiz</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php
page_footer();
