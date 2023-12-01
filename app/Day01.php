<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day01
{
    public function run()
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');


        $response = $client->request('GET', 'https://adventofcode.com/2023/day/1/input', ['cookies' => $jar]);
        echo '<pre>';
        $data = (string)$response->getBody();
        $hate = ['sevenine', 'eightwo', 'eightthree', 'oneight', 'threeight', 'fiveight', 'nineight', 'twone'];
        $etah = [79, 82, 83, 18, 38, 58, 98, 21];
        $words = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        $sum = 0;
        $data = preg_split('/\r\n|\r|\n/', $data);
        foreach ($data as $line) {
            $first = 0;
            $last = 0;
            Print_r($line);
            echo PHP_EOL;
            $line = str_replace($hate, $etah, $line);
            $line = str_replace($words, $numbers, $line);
            Print_r($line);
            echo PHP_EOL;

            foreach (str_split($line) as $l) {
                if (ctype_digit($l)) {
                    $first = $l;
                    break;
                }
            }
            foreach (str_split(strrev($line)) as $l) {
                if (ctype_digit($l)) {
                    $last = $l;
                    break;
                }
            }

            $sum += (int)($first . $last);
            var_dump($first, $last, $sum);
        }
        echo "Part 2 answer: $sum";
    }
}