<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day04
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/4/input', ['cookies' => $jar]);
        echo '<pre>';
        $data = (string)$response->getBody();

//        $data = 'Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
//Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
//Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
//Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
//Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
//Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11';

        $data = preg_split('/\r\n|\r|\n/', $data);
//        var_dump($data[0]);
        $wSum = 0;
        foreach ($data as $line) {
            if (strlen($line) < 1) {
                break;
            }
            [$card, $line] = explode(':', $line);
            $card = trim(str_replace('Card', ' ', $card));
            [$test[$card]['winners'], $test[$card]['numbers']] = explode('|', $line);
            preg_match_all('(\d+)', $test[$card]['winners'], $winners);
            $test[$card]['winners'] = $winners[0];
            preg_match_all('(\d+)', $test[$card]['numbers'], $numbers);
            $test[$card]['numbers'] = $numbers[0];
            $wNumbers = array_intersect($test[$card]['winners'], $test[$card]['numbers']);
            $thisCardSum = 0;
            if (count($wNumbers) > 0) {
                $cardSum = 1;
                $doub = 1;
                for ($i = 1; $i < count($wNumbers); $i++) {
                    $cardSum += $doub;

                    $doub *= 2;
                }
//                echo "$cardSum|$wSum";
                $thisCardSum += $cardSum;
            }
            $wSum += $thisCardSum;

//            var_dump($wNumbers, $thisCardSum, $wSum);
//            die;
        }
        var_dump($wSum);
    }

}