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
        $data2 = 'Time:      7  15   30
Distance:  9  40  200
';
        $raceData = [];
        $data = preg_split('/\r\n|\r|\n/', $data);
//        var_dump($data);
        $temp[0] = explode('Time:', $data[0]);
        $temp[1] = explode('Distance:', $data[1]);
        $temp[0][1] = str_replace(' ', '', $temp[0][1]);
        $temp[1][1] = str_replace(' ', '', $temp[1][1]);
        preg_match_all('(\d+)', $temp[0][1], $matches[0]);
        preg_match_all('(\d+)', $temp[1][1], $matches[1]);
        foreach ($matches[0][0] as $key => $match) {
            $raceData[$key]['Time'] = $match;
            $raceData[$key]['Distance'] = $matches[1][0][$key];
        }

        var_dump($raceData);

        $multiple = 1;
        foreach ($raceData as $race) {
            $count = 0;
            for ($i = 0; $i < $race['Time']; $i++) {
                $speed = $i;
                $distance = $i * ($race['Time'] - $i);
                if ($distance > $race['Distance']) {
                    $count++;
//                    echo $race['Distance'] . "|" . $distance . "\n";
                }
            }
            $multiple *= $count;
            var_dump($count);
        }
        var_dump($multiple);
    }
}