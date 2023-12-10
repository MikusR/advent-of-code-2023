<?php

declare(strict_types=1);

use App\Day11;

require_once __DIR__ . '/../vendor/autoload.php';
echo '<pre>';
var_dump(opcache_get_status()['jit']);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$day = new Day11();
$day->run();