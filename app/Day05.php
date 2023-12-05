<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day05
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/5/input', ['cookies' => $jar]);
        echo '<pre>';
        $data = (string)$response->getBody();
        $data = preg_split('/\r\n|\r|\n/', $data);
        var_dump($data);
    }
}