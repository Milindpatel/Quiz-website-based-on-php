<?php
/** Form fields shared by sign-up and the profile page. Expects $f (field values). */
$labels = [
    'first_name' => ['First name', 'text', 'given-name'],
    'last_name' => ['Last name', 'text', 'family-name'],
    'email' => ['Email', 'email', 'email'],
    'phone' => ['Phone number', 'tel', 'tel'],
    'address' => ['Address', 'text', 'street-address'],
];
foreach ($labels as $name => [$label, $type, $autocomplete]): ?>
  <div class="mb-3">
    <label class="form-label" for="<?= $name ?>"><?= e($label) ?></label>
    <input type="<?= $type ?>" class="form-control" id="<?= $name ?>" name="<?= $name ?>" value="<?= e($f[$name]) ?>" autocomplete="<?= $autocomplete ?>" required>
  </div>
<?php endforeach;
