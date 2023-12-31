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

        $data2 = 'seeds: 79 14 55 13

seed-to-soil map:
50 98 2
52 50 48

soil-to-fertilizer map:
0 15 37
37 52 2
39 0 15

fertilizer-to-water map:
49 53 8
0 11 42
42 0 7
57 7 4

water-to-light map:
88 18 7
18 25 70

light-to-temperature map:
45 77 23
81 45 19
68 64 13

temperature-to-humidity map:
0 69 1
1 0 69

humidity-to-location map:
60 56 37
56 93 4';

        $data = preg_split('/\n\n/', $data);
        $almanac = [];

        foreach ($data as $key => $d) {
            if ($key === 0) {
                $temp = explode('seeds:', $d);
                preg_match_all('(\d+)', $temp[1], $matches);
                $seeds = array_map('intval', $matches[0]);
            } else {
                $temp = preg_split('/:\n/', $d);
                $temp[1] = preg_split('/\n/', $temp[1]);
                foreach ($temp[1] as $t) {
                    if (strlen($t) > 0) {
                        preg_match_all('(\d+)', $t, $matches);
                        if (count($matches) > 0) {
                            $almanac[$temp[0]][] =
                                [
                                    'destination' => (int)$matches[0][0],
                                    'source' => (int)$matches[0][1],
                                    'range' => (int)$matches[0][2]
                                ];
                        }
                    }
                }
            }
        }
        $minimum = false;

        foreach ($seeds as $key => $seed) {
            var_dump('seed:', $seed);
            if ($key % 2 === 0) {
                for ($i = 0; $i < $seeds[$key + 1]; $i++) {
                    $destination = $seed + $i;
                    $dest = $destination;
                    //var_dump('seed:',$destination);
                    foreach ($almanac as $item) {
                        foreach ($item as $line) {
                            if (($destination >= $line['source']) &&
                                ($destination <= $line['source'] + $line['range'] - 1)) {
                                $dest = $line['destination'] + abs($line['source'] - $destination);
                            }
                        }
                        $destination = $dest;
                    }
                    if ($minimum === false) {
                        $minimum = $destination;
                    }
                    if ($destination < $minimum) {
                        $minimum = $destination;
                    }
                }
            }
        }
        var_dump($minimum);
    }
}