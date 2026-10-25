<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/layout.php';

$user = require_login();
$slug = (string) ($_GET['subject'] ?? '');
if (!isset(SUBJECTS[$slug])) {
    http_response_code(404);
    page_header('Not found');
    echo '<p>Unknown quiz. <a href="/">Back to the home page</a>.</p>';
    page_footer();
    exit;
}
$subject = SUBJECTS[$slug];

/** Loads questions by id, in the given order. */
function load_questions(array $ids): array
{
    if (!$ids) {
        return [];
    }
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = db()->prepare("SELECT id, question, option1, option2, option3, option4, answer FROM questions WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $byId = array_column($stmt->fetchAll(), null, 'id');
    return array_values(array_filter(array_map(fn ($id) => $byId[$id] ?? null, $ids)));
}

$errors = [];
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_post_with_csrf();
    // The questions come from the session, so they can't be swapped by the browser.
    $ids = $_SESSION['quiz'][$slug] ?? [];
    $questions = load_questions($ids);
    $answers = (array) ($_POST['answer'] ?? []);

    if (!$questions) {
        flash('That quiz expired. Here is a new one.', 'info');
        redirect('/quiz.php?subject=' . urlencode($slug));
    }
    foreach ($questions as $q) {
        if (!in_array($answers[$q['id']] ?? null, ['1', '2', '3', '4'], true)) {
            $errors[] = 'Please answer every question.';
            break;
        }
    }
    if (!$errors) {
        $score = 0;
        foreach ($questions as $q) {
            $score += (int) $answers[$q['id']] === (int) $q['answer'] ? 1 : 0;
        }
        $stmt = db()->prepare('INSERT INTO scores (user_id, subject, score, total, taken_at) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$user['id'], $slug, $score, count($questions), gmdate('Y-m-d H:i')]);
        unset($_SESSION['quiz'][$slug]);
        $result = ['score' => $score, 'total' => count($questions)];
    }
} else {
    // Pick a new random set of questions for this attempt.
    $ids = db()->prepare('SELECT id FROM questions WHERE subject = ?');
    $ids->execute([$slug]);
    $ids = array_map('intval', $ids->fetchAll(PDO::FETCH_COLUMN));
    shuffle($ids);
    $_SESSION['quiz'][$slug] = array_slice($ids, 0, QUESTIONS_PER_QUIZ);
    $questions = load_questions($_SESSION['quiz'][$slug]);
    $answers = [];
}

page_header($subject['name'] . ' quiz');
?>
<h1 class="h3 mb-3"><?= e($subject['name']) ?> quiz</h1>

<?php if ($result): ?>
  <?php if ($result['score'] >= PASS_MARK): ?>
    <div class="alert alert-success">
      You passed the <?= e($subject['name']) ?> test with <?= $result['score'] ?> out of <?= $result['total'] ?>. Well done!
    </div>
  <?php else: ?>
    <div class="alert alert-warning">
      You scored <?= $result['score'] ?> out of <?= $result['total'] ?>. You need <?= PASS_MARK ?> to pass, so please try again later!
    </div>
  <?php endif; ?>
  <a class="btn btn-primary" href="/quiz.php?subject=<?= e($slug) ?>">Try again</a>
  <a class="btn btn-outline-secondary ms-2" href="/scores.php">My scores</a>
  <a class="btn btn-outline-secondary ms-2" href="/">Home</a>
<?php else: ?>
  <?php error_list($errors); ?>
  <form method="post" action="/quiz.php?subject=<?= e($slug) ?>">
    <?= csrf_field() ?>
    <?php foreach ($questions as $n => $q): ?>
      <fieldset class="card mb-3">
        <div class="card-body">
          <legend class="h6 question"><?= $n + 1 ?>. <?= e($q['question']) ?></legend>
          <?php for ($o = 1; $o <= 4; $o++):
              $id = "q{$q['id']}-$o"; ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="answer[<?= (int) $q['id'] ?>]" id="<?= $id ?>" value="<?= $o ?>"
                     <?= ($answers[$q['id']] ?? null) === (string) $o ? 'checked' : '' ?> required>
              <label class="form-check-label" for="<?= $id ?>"><?= e($q["option$o"]) ?></label>
            </div>
          <?php endfor; ?>
        </div>
      </fieldset>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary btn-lg">Finish</button>
  </form>
<?php endif; ?>
<?php
page_footer();
