# QuizoMania

A small quiz website in plain PHP. Sign up, take a 10-question multiple-choice quiz on **Java** or **C** (questions are picked at random from 20 per subject), and see your score history. You pass with 8 out of 10.

## Requirements

- PHP 8.2+ with PDO (MySQL/MariaDB or SQLite)
- [Composer](https://getcomposer.org/) for running the tests

## Running it

1. Create a database (MySQL/MariaDB shown; SQLite works too):

   ```sh
   mysql -u root -e "CREATE DATABASE quiz CHARACTER SET utf8mb4"
   ```

2. Create the tables and load the questions:

   ```sh
   DB_DSN="mysql:host=127.0.0.1;dbname=quiz;charset=utf8mb4" DB_USER=root DB_PASS=secret php bin/setup.php
   ```

3. Serve the `public/` folder, for example with PHP's built-in server:

   ```sh
   DB_DSN="mysql:host=127.0.0.1;dbname=quiz;charset=utf8mb4" DB_USER=root DB_PASS=secret php -S localhost:8000 -t public
   ```

   For a quick try without MySQL, use `DB_DSN=sqlite:quiz.sqlite` for both commands.

In Apache or nginx, point the document root at `public/` so `src/`, `db/` and `vendor/` are not reachable from the web, and set `DB_DSN`, `DB_USER` and `DB_PASS` as environment variables.

## Project layout

| Path | What's there |
| --- | --- |
| `public/` | Pages: home, sign up, log in/out, quiz, profile, scores |
| `src/` | Shared setup (session, database, CSRF, helpers), layout and schema |
| `db/questions.php` | The quiz questions and answers |
| `bin/setup.php` | Creates the tables and loads the questions |
| `tests/` | End-to-end tests (PHPUnit + the built-in server + SQLite) |

## Security

- All queries are prepared statements.
- Passwords are hashed with `password_hash()` and never shown back to the user.
- Every form has a CSRF token, and the session ID changes on login.
- Answers are checked on the server and never sent to the browser.

## Tests

```sh
composer install
composer test
```

CI runs the tests on every push.
