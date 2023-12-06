<?php

declare(strict_types=1);

use App\Day07;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$day = new Day07();
$day->run();