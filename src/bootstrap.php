<?php

declare(strict_types=1);

/*
 * Shared setup for every page: config, session, database and small helpers.
 */

const SUBJECTS = [
    'java' => ['name' => 'Java', 'tagline' => 'Write once, run anywhere', 'learn' => 'https://dev.java/learn/'],
    'c' => ['name' => 'C', 'tagline' => 'The language every programmer should know', 'learn' => 'https://en.cppreference.com/w/c'],
];
const QUESTIONS_PER_QUIZ = 10;
const PASS_MARK = 8;

function config(string $key, string $default = ''): string
{
    $value = getenv($key);
    return $value === false ? $default : $value;
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            config('DB_DSN', 'mysql:host=127.0.0.1;dbname=quiz;charset=utf8mb4'),
            config('DB_USER', 'root'),
            config('DB_PASS'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        );
    }
    return $pdo;
}

function start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_name('quizomania');
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => ($_SERVER['HTTPS'] ?? '') === 'on',
    ]);
    session_start();
}

/** HTML-escape for output. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function flash(string $message, string $kind = 'success'): void
{
    $_SESSION['flash'] = ['message' => $message, 'kind' => $kind];
}

function take_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(24));
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

/** Stops the request unless a POST carries this session's CSRF token. */
function require_post_with_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method not allowed');
    }
    if (!hash_equals(csrf_token(), (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(403);
        exit('Your form expired. Please go back, reload the page and try again.');
    }
}

function current_user(): ?array
{
    static $user = false;
    if ($user === false) {
        $user = null;
        if (isset($_SESSION['user_id'])) {
            $stmt = db()->prepare('SELECT id, first_name, last_name, email, phone, address FROM users WHERE id = ?');
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch() ?: null;
        }
    }
    return $user;
}

function require_login(): array
{
    $user = current_user();
    if (!$user) {
        flash('Please log in first.', 'danger');
        redirect('/login.php');
    }
    return $user;
}

function log_in(int $userId): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;
}

/** Trimmed text fields from a form. */
function form_fields(array $names): array
{
    $values = [];
    foreach ($names as $name) {
        $values[$name] = trim((string) ($_POST[$name] ?? ''));
    }
    return $values;
}

/** Validation errors for the profile fields shared by sign-up and the profile page. */
function profile_errors(array $f, ?int $currentUserId = null): array
{
    $errors = [];
    foreach (['first_name' => 'First name', 'last_name' => 'Last name', 'phone' => 'Phone number', 'address' => 'Address'] as $key => $label) {
        if ($f[$key] === '') {
            $errors[] = "$label is required.";
        } elseif (mb_strlen($f[$key]) > ($key === 'address' ? 500 : 100)) {
            $errors[] = "$label is too long.";
        }
    }
    if (!filter_var($f['email'], FILTER_VALIDATE_EMAIL) || strlen($f['email']) > 254) {
        $errors[] = 'Please enter a valid email address.';
    } else {
        $stmt = db()->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([strtolower($f['email'])]);
        $owner = $stmt->fetchColumn();
        if ($owner !== false && (int) $owner !== $currentUserId) {
            $errors[] = 'An account with that email already exists.';
        }
    }
    return $errors;
}

start_session();
