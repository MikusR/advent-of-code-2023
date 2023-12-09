<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day09
{
    public function run(): void
    {
        echo '<pre>';
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/9/input', ['cookies' => $jar]);
        $data = (string)$response->getBody();
        $data2 = '0 3 6 9 12 15
1 3 6 10 15 21
10 13 16 21 30 45
';
        $data = preg_split('/\r\n|\r|\n/', $data);
        $history = [];
        foreach ($data as $line) {
            if (strlen($line) > 0) {
                $history[] = array_map('intval', (explode(' ', $line)));
            }
        }

//        var_dump($history);
        $interpol = [];
        foreach ($history as $key => $line) {
            echo implode(' ', $line) . "\n";
            $currentLine = $line;
            $interpol[$key][] = $line;


            while (array_unique($currentLine) != [0]) {
//                var_dump(array_unique($currentLine));
                $newLine = [];
                $last = count($currentLine);
                for ($i = 0; $i < $last - 1; $i++) {
                    $newLine[] = $currentLine[$i + 1] - $currentLine[$i];
                }
                echo implode(' ', $newLine) . "\n";
                $interpol[$key][] = $newLine;
                $currentLine = $newLine;
            }
            echo "\n\n";
        }
        foreach ($interpol as $interpolLine => $item) {
            $interpol[$interpolLine] = array_reverse($item);
        }

        foreach ($interpol as $interpolLine => $line) {
            $newElement = 0;
            $newLine = [];
            foreach ($line as $key => $entry) {
                $newEntry = $entry;
                $newElement = $entry[array_key_last($entry)] + $newElement;
                $newEntry[] = $newElement;
                $interpol[$interpolLine][$key] = $newEntry;
            }
        }
        foreach ($interpol as $interpolLine => $item) {
            $interpol[$interpolLine] = array_reverse($item);
        }
        $lastElementSum = 0;
        foreach ($interpol as $line) {
            $lastElementSum += $line[0][array_key_last($line[0])];
            foreach ($line as $entry) {
                echo implode(' ', $entry) . "\n";
            }
            echo "\n\n";
        }
        var_dump($lastElementSum);
    }

}