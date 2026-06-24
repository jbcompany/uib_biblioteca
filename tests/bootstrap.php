<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$projectRoot = dirname(__DIR__);

// Force test environment for PHPUnit runs.
putenv('APP_ENV=test');
$_ENV['APP_ENV'] = 'test';
$_SERVER['APP_ENV'] = 'test';

if (class_exists(\Dotenv\Dotenv::class)) {
	if (file_exists($projectRoot . '/.env')) {
		\Dotenv\Dotenv::createUnsafeMutable($projectRoot, '.env')->safeLoad();
	}

	if (file_exists($projectRoot . '/.env.testing')) {
		\Dotenv\Dotenv::createUnsafeMutable($projectRoot, '.env.testing')->safeLoad();
	}
}

// Ensure APP_ENV stays on test even if a file sets a different value.
putenv('APP_ENV=test');
$_ENV['APP_ENV'] = 'test';
$_SERVER['APP_ENV'] = 'test';
