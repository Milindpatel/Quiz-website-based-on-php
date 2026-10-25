<?php

declare(strict_types=1);

/** Creates the tables (if missing) and loads the questions when the table is empty. */
function install_schema(PDO $pdo): void
{
    $mysql = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql';
    $id = $mysql ? 'INT AUTO_INCREMENT PRIMARY KEY' : 'INTEGER PRIMARY KEY AUTOINCREMENT';
    $suffix = $mysql ? ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4' : '';

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id $id,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(254) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        phone VARCHAR(100) NOT NULL,
        address VARCHAR(500) NOT NULL
    )$suffix");

    $pdo->exec("CREATE TABLE IF NOT EXISTS questions (
        id $id,
        subject VARCHAR(20) NOT NULL,
        question TEXT NOT NULL,
        option1 TEXT NOT NULL,
        option2 TEXT NOT NULL,
        option3 TEXT NOT NULL,
        option4 TEXT NOT NULL,
        answer INT NOT NULL
    )$suffix");

    $pdo->exec("CREATE TABLE IF NOT EXISTS scores (
        id $id,
        user_id INT NOT NULL,
        subject VARCHAR(20) NOT NULL,
        score INT NOT NULL,
        total INT NOT NULL,
        taken_at VARCHAR(25) NOT NULL
    )$suffix");

    if ((int) $pdo->query('SELECT COUNT(*) FROM questions')->fetchColumn() === 0) {
        $insert = $pdo->prepare('INSERT INTO questions (subject, question, option1, option2, option3, option4, answer) VALUES (?, ?, ?, ?, ?, ?, ?)');
        foreach (require __DIR__ . '/../db/questions.php' as $subject => $questions) {
            foreach ($questions as $q) {
                $insert->execute([$subject, $q['question'], ...$q['options'], $q['answer']]);
            }
        }
    }
}
