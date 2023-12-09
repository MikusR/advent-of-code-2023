<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day10
{
    public function run(): void
    {
        echo '<pre>';
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/10/input', ['cookies' => $jar]);
        $data = (string)$response->getBody();
        $data2 = '0 3 6 9 12 15
1 3 6 10 15 21
10 13 16 21 30 45
';
        $data = preg_split('/\r\n|\r|\n/', $data);
        var_dump($data);
    }
}