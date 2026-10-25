<?php

// Creates the tables and loads the quiz questions. Safe to run more than once.
// Usage: DB_DSN=... DB_USER=... DB_PASS=... php bin/setup.php

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/schema.php';

install_schema(db());
echo "Database ready.\n";
