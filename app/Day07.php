<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day07
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/7/input', ['cookies' => $jar]);
        echo '<pre>';
        $data = (string)$response->getBody();
        $data2 = '';
        $data = preg_split('/\r\n|\r|\n/', $data);
        var_dump($data);
    }
}