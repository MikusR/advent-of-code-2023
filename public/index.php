<?php

declare(strict_types=1);

use App\Day01;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$day01 = new Day01();
$day01->run();