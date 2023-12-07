<?php

declare(strict_types=1);

use App\Day08;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$day = new Day08();
$day->run();