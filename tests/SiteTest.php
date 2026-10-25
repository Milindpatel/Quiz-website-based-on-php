<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * End-to-end tests: runs the site with PHP's built-in server on a throwaway
 * SQLite database and drives it over HTTP like a browser would.
 */
final class SiteTest extends TestCase
{
    private static $server;
    private static string $base;
    private static string $dbFile;
    private static PDO $db;
    private string $cookies;

    public static function setUpBeforeClass(): void
    {
        self::$dbFile = tempnam(sys_get_temp_dir(), 'quiz') . '.sqlite';
        $env = ['DB_DSN' => 'sqlite:' . self::$dbFile, 'DB_USER' => '', 'DB_PASS' => ''] + getenv();
        $root = dirname(__DIR__);

        $setup = proc_open([PHP_BINARY, "$root/bin/setup.php"], [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, $root, $env);
        stream_get_contents($pipes[1]);
        self::assertSame(0, proc_close($setup), 'bin/setup.php failed');

        $port = 18000 + random_int(0, 999);
        self::$base = "http://127.0.0.1:$port";
        self::$server = proc_open(
            [PHP_BINARY, '-S', "127.0.0.1:$port", '-t', "$root/public"],
            [1 => ['file', '/dev/null', 'w'], 2 => ['file', '/dev/null', 'w']],
            $pipes,
            $root,
            $env,
        );
        for ($i = 0; $i < 50 && !@fsockopen('127.0.0.1', $port); $i++) {
            usleep(100_000);
        }
        self::$db = new PDO('sqlite:' . self::$dbFile, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public static function tearDownAfterClass(): void
    {
        proc_terminate(self::$server);
        @unlink(self::$dbFile);
    }

    protected function setUp(): void
    {
        $this->cookies = tempnam(sys_get_temp_dir(), 'cookies');
    }

    protected function tearDown(): void
    {
        @unlink($this->cookies);
    }

    /** @return array{0:int,1:string,2:?string} status, body, redirect location */
    private function request(string $method, string $path, array $form = []): array
    {
        $ch = curl_init(self::$base . $path);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIEJAR => $this->cookies,
            CURLOPT_COOKIEFILE => $this->cookies,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HEADER => true,
            CURLOPT_PROXY => '',
        ]);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($form));
        }
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        preg_match('/^Location: (.*)$/mi', substr($raw, 0, $headerSize), $m);
        return [$status, substr($raw, $headerSize), isset($m[1]) ? trim($m[1]) : null];
    }

    private function get(string $path): string
    {
        return $this->request('GET', $path)[1];
    }

    private function csrf(string $html): string
    {
        preg_match('/name="csrf" value="([^"]+)"/', $html, $m);
        return $m[1] ?? '';
    }

    private function post(string $path, array $form, ?string $tokenFrom = '/'): array
    {
        $form['csrf'] ??= $this->csrf($this->get($tokenFrom));
        return $this->request('POST', $path, $form);
    }

    private function signUp(string $email = 'alice@example.com', array $extra = []): array
    {
        return $this->post('/signup.php', $extra + [
            'first_name' => 'Alice', 'last_name' => 'Smith', 'email' => $email,
            'password' => 'password123', 'phone' => '555-0100', 'address' => '1 Main St',
        ], '/signup.php');
    }

    private function uniqueEmail(): string
    {
        return 'user' . bin2hex(random_bytes(4)) . '@example.com';
    }

    public function testHomePageListsBothQuizzes(): void
    {
        $html = $this->get('/');
        $this->assertStringContainsString('Start Java quiz', $html);
        $this->assertStringContainsString('Start C quiz', $html);
    }

    public function testSignUpLogsYouInAndHashesThePassword(): void
    {
        $email = $this->uniqueEmail();
        [, , $location] = $this->signUp($email);
        $this->assertSame('/', $location);
        $this->assertStringContainsString('Welcome to QuizoMania, Alice!', $this->get('/'));

        $hash = self::$db->query("SELECT password_hash FROM users WHERE email = '$email'")->fetchColumn();
        $this->assertTrue(password_verify('password123', $hash));
    }

    public function testSignUpValidation(): void
    {
        $email = $this->uniqueEmail();
        $this->signUp($email);
        $this->cookies = tempnam(sys_get_temp_dir(), 'cookies');

        [$status, $html] = $this->signUp($email);
        $this->assertSame(200, $status);
        $this->assertStringContainsString('An account with that email already exists.', $html);

        [, $html] = $this->signUp($this->uniqueEmail(), ['password' => 'short', 'first_name' => '']);
        $this->assertStringContainsString('Password must be at least 8 characters.', $html);
        $this->assertStringContainsString('First name is required.', $html);
    }

    public function testLoginAndLogout(): void
    {
        $email = $this->uniqueEmail();
        $this->signUp($email);
        $this->post('/logout.php', []);
        $this->assertStringContainsString('You are logged out.', $this->get('/'));

        [, , $location] = $this->post('/login.php', ['email' => $email, 'password' => 'wrong-password']);
        $this->assertSame('/login.php', $location);
        $this->assertStringContainsString('Invalid email or password.', $this->get('/login.php'));

        // The old login query was built by string concatenation.
        [, , $location] = $this->post('/login.php', ['email' => "' OR '1'='1", 'password' => "' OR '1'='1"]);
        $this->assertSame('/login.php', $location);

        [, , $location] = $this->post('/login.php', ['email' => strtoupper($email), 'password' => 'password123']);
        $this->assertSame('/', $location);
        $this->assertStringContainsString('Hi, Alice', $this->get('/'));
    }

    public function testPostsWithoutCsrfTokenAreRejected(): void
    {
        [$status] = $this->request('POST', '/login.php', ['email' => 'a@b.co', 'password' => 'x']);
        $this->assertSame(403, $status);
    }

    public function testPagesNeedLogin(): void
    {
        foreach (['/quiz.php?subject=java', '/profile.php', '/scores.php'] as $path) {
            [, , $location] = $this->request('GET', $path);
            $this->assertSame('/login.php', $location, $path);
        }
    }

    public function testQuizIsGradedOnTheServer(): void
    {
        $this->signUp($this->uniqueEmail());
        $html = $this->get('/quiz.php?subject=c');
        preg_match_all('/name="answer\[(\d+)\]" id="q\d+-1"/', $html, $m);
        $ids = array_map('intval', $m[1]);
        $this->assertCount(10, $ids);

        // Every question shown belongs to the C quiz (the old C page showed Java questions).
        $subjects = self::$db->query('SELECT DISTINCT subject FROM questions WHERE id IN (' . implode(',', $ids) . ')')->fetchAll(PDO::FETCH_COLUMN);
        $this->assertSame(['c'], $subjects);

        $correct = self::$db->query('SELECT id, answer FROM questions WHERE id IN (' . implode(',', $ids) . ')')->fetchAll(PDO::FETCH_KEY_PAIR);
        $answers = [];
        foreach ($ids as $i => $id) {
            // Get the first two wrong on purpose.
            $answers[$id] = $i < 2 ? (string) ($correct[$id] % 4 + 1) : (string) $correct[$id];
        }

        [, $html] = $this->post('/quiz.php?subject=c', ['answer' => $answers, 'csrf' => $this->csrf($html)]);
        $this->assertStringContainsString('You passed the C test with 8 out of 10.', $html);

        $scores = $this->get('/scores.php');
        $this->assertStringContainsString('8 / 10', $scores);
        $this->assertStringContainsString('Total attempts: 1', $scores);
    }

    public function testQuizNeedsEveryAnswerAndIgnoresSwappedQuestions(): void
    {
        $this->signUp($this->uniqueEmail());
        $html = $this->get('/quiz.php?subject=java');
        $token = $this->csrf($html);

        [, $html] = $this->post('/quiz.php?subject=java', ['answer' => [], 'csrf' => $token]);
        $this->assertStringContainsString('Please answer every question.', $html);

        // Answers for questions that were not in this quiz don't count.
        $other = self::$db->query("SELECT id, answer FROM questions WHERE subject = 'c'")->fetchAll(PDO::FETCH_KEY_PAIR);
        [, $html] = $this->post('/quiz.php?subject=java', ['answer' => array_map('strval', $other), 'csrf' => $token]);
        $this->assertStringContainsString('Please answer every question.', $html);
    }

    public function testUnknownQuizIs404(): void
    {
        $this->signUp($this->uniqueEmail());
        [$status] = $this->request('GET', '/quiz.php?subject=cobol');
        $this->assertSame(404, $status);
    }

    public function testProfileNeverShowsThePasswordAndEscapesInput(): void
    {
        $this->signUp($this->uniqueEmail(), ['first_name' => '<script>alert(1)</script>']);
        $html = $this->get('/profile.php');
        $this->assertStringNotContainsString('password123', $html);
        $this->assertStringNotContainsString('<script>alert(1)</script>', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $html);
    }

    public function testProfileUpdateAndPasswordChange(): void
    {
        $email = $this->uniqueEmail();
        $this->signUp($email);
        $this->post('/profile.php', [
            'first_name' => 'Alicia', 'last_name' => 'Smith', 'email' => $email,
            'phone' => '555-0101', 'address' => '2 Main St', 'new_password' => 'new-password-1',
        ], '/profile.php');
        $this->assertStringContainsString('value="Alicia"', $this->get('/profile.php'));

        $this->post('/logout.php', []);
        [, , $location] = $this->post('/login.php', ['email' => $email, 'password' => 'new-password-1']);
        $this->assertSame('/', $location);
    }
}
