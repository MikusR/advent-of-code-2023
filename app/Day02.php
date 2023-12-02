<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day02
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');

        $gameIdSum = 0;
        $red = 12;
        $green = 13;
        $blue = 14;
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/2/input', ['cookies' => $jar]);
        echo '<pre>';
        $data = (string)$response->getBody();
        $data = preg_split('/\r\n|\r|\n/', $data);
//        var_dump($data);
        foreach ($data as $line) {
            if (strlen($line) <= 0) {
                break;
            }
            $max = ['blue' => 0, 'red' => 0, 'green' => 0];
            $continue = true;
            [$a, $b] = explode(': ', $line);
            $game = str_replace('Game ', '', $a);
            $sets = explode('; ', $b);
            foreach ($sets as $set) {
                $colors = explode(', ', $set);

                foreach ($colors as $color) {
                    [$x, $y] = explode(' ', $color);
                    $max[$y] = max($max[$y], $x);
                    if ($$y < $x) {
                        $continue = false;
                    }
                }
            }
            $gameIdSum += array_product($max);
//            if ($continue) {
//                var_dump($line, $max);

//            }
        }
        echo $gameIdSum;
    }
}