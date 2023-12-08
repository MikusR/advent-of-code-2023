<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day08
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/8/input', ['cookies' => $jar]);
        $data = (string)$response->getBody();
        echo '<pre>';
        $data2 = 'LR

11A = (11B, XXX)
11B = (XXX, 11Z)
11Z = (11B, XXX)
22A = (22B, XXX)
22B = (22C, 22C)
22C = (22Z, 22Z)
22Z = (22B, 22B)
XXX = (XXX, XXX)
';
        $data = preg_split('/\r\n|\r|\n/', $data);
        $path = str_split($data[0]);
        $map = [];
        unset($data[0]);
        foreach ($data as $line) {
            if (strlen($line) > 0) {
                preg_match('/(\w+) = \((\w+), (\w+)\)/', $line, $matches);
                $map[$matches[1]] = ['L' => $matches[2], 'R' => $matches[3]];
            }
        }
        foreach ($map as $key => $item) {
            if (substr($key, 2, 1) === 'A') {
                $startLocation[] = $key;
            }
            if (substr($key, 2, 1) === 'Z') {
                $targetLocation[] = $key;
            }
        }
//
        $location = $startLocation;
        $numberOfSteps = 0;
        $step = 0;
        $length = count($path);
        $found = false;
        while ($found === false) {
            $numberOfSteps++;
            $nextStep = $path[$step];
            foreach ($location as $key => $loc) {
                $location[$key] = $map[$loc][$nextStep];
            }
//            var_dump($location);
            if (count(
                    array_diff($location, $targetLocation)
                ) === 0) {
                $found = true;
            }

            if ($length - 1 <= $step) {
                $step = 0;
            } else {
                $step++;
            }
        }
        var_dump($numberOfSteps);
    }
}