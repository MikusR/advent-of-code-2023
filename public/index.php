<?php

declare(strict_types=1);

use App\Day09;

require_once __DIR__ . '/../vendor/autoload.php';

//var_dump(opcache_get_status()['jit']);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$day = new Day09();
$day->run();