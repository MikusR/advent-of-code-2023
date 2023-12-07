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
        $data2 = '32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483
';
        $list = [];
        $cards = [
            'A' => 99,
            'K' => 88,
            'Q' => 77,
            'J' => 66,
            'T' => 55,
            '9' => 44,
            '8' => 33,
            '7' => 22,
            '6' => 21,
            '5' => 20,
            '4' => 19,
            '3' => 15,
            '2' => 10
        ];
        $types = [
            'Five of a kind' => 7,
            'Four of a kind' => 6,
            'Full house' => 5,
            'Three of a kind' => 4,
            'Two pair' => 3,
            'One pair' => 2,
            'High card' => 1
        ];
        $data = preg_split('/\r\n|\r|\n/', $data);
        foreach ($data as $key => $line) {
            if (strlen($line) > 0) {
                [$hand, $bid] = explode(' ', $line);
                $hand = str_split($hand);
                $unique = array_count_values($hand);
                arsort($unique);
                $type = 'High card';
//                $type = $unique;
                if (count($unique) === 1) {
                    $type = 'Five of a kind';
                }
                if (count($unique) === 2) {
                    if ($unique[array_key_first($unique)] === 4) {
                        $type = 'Four of a kind';
                    }
                    if ($unique[array_key_first($unique)] === 3) {
                        $type = 'Full house';
                    }
                }
                if (count($unique) === 3) {
                    if ($unique[array_key_first($unique)] === 3) {
                        $type = 'Three of a kind';
                    }
                    if ($unique[array_key_first($unique)] === 2) {
                        $type = 'Two pair';
                    }
                }
                if (count($unique) === 4) {
                    $type = 'One pair';
                }
                $sortOrder = '';
                $sortOrder .= $types[$type];

                foreach ($hand as $card) {
                    $sortOrder .= $cards[$card];
                }
                $hand = implode('', $hand);
                $list[$sortOrder] = ['hand' => $hand, 'bid' => trim($bid), 'type' => $type];
            }
        }
        krsort($list);
        $rank = count($list);
        $sum = 0;
        foreach ($list as $hand) {
            $sum += $hand['bid'] * $rank;
            $rank--;
        }
        var_dump($list);
        var_dump('Sum: ', $sum);
    }
}