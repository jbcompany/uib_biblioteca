<?php

$autoloadFile = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadFile)) {
    require_once $autoloadFile;
}

if (class_exists(\Dotenv\Dotenv::class) && file_exists(__DIR__ . '/.env')) {
    // Load local environment file without overwriting values provided by the OS.
    \Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->safeLoad();
}

$appEnv = getenv('APP_ENV') ?: 'dev';

if ($appEnv === 'test') {
    $servername = getenv('TEST_DB_HOST') ?: (getenv('DB_HOST') ?: 'localhost');
    $username = getenv('TEST_DB_USER') ?: (getenv('DB_USER') ?: 'root');
    $password = getenv('TEST_DB_PASS') ?: (getenv('DB_PASS') ?: '');
    $dbname = getenv('TEST_DB_NAME') ?: 'biblioteca_test';
} else {
    $servername = getenv('DB_HOST') ?: 'localhost';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASS') ?: '';
    $dbname = getenv('DB_NAME') ?: 'biblioteca';
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
