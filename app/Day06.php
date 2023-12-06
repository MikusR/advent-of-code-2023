<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day06
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/6/input', ['cookies' => $jar]);
        echo '<pre>';
        $data = (string)$response->getBody();
        var_dump($data);
    }
}