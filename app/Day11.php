<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day11
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/11/input', ['cookies' => $jar]);
        $data = (string)$response->getBody();
        $data2 = '
        ';
        $data = preg_split('/\r\n|\r|\n/', $data);
        var_dump($data);
    }
}