<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day08lacm
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


        $lacm = [];
        $length = count($path);
        foreach ($location as $key => $loc) {
            $time_start = microtime(true);
            $found = false;
            $loca = $loc;
            $numberOfSteps = 0;
            $step = 0;

            while (!$found) {
                $numberOfSteps++;
                $nextStep = $path[$step];
                $nextLocation = $map[$loca][$nextStep];

                $loca = $nextLocation;
                if (in_array($loca, $targetLocation)) {
                    $lacm[$startLocation[$key]] = $numberOfSteps;
                    var_dump($numberOfSteps);

                    $found = true;
                }
                if ($length - 1 <= $step) {
                    $step = 0;
                } else {
                    $step++;
                }
               
                $time_end = microtime(true);
                $time = $time_end - $time_start;
                var_dump($time);
                break;
            }
        }
        var_dump($lacm);
        $loops = 15995167053923;

        var_dump($loops * $time);
    }
}