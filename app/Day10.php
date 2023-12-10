<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day10
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/10/input', ['cookies' => $jar]);
        $data = (string)$response->getBody();
        $data2 = 'FF7FSF7F7F7F7F7F---7
L|LJ||||||||||||F--J
FL-7LJLJ||||||LJL-77
F--JF--7||LJLJ7F7FJ-
L---JF-JLJ.||-FJLJJ7
|F|F-JF---7F7-L7L|7|
|FFJF7L7F-JF7|JL---7
7-L-JL7||F7|L7F-7F7|
L.L7LFJ|||||FJL7||LJ
L7JLJL-JLJLJL--JLJ.L
';
//        echo $data;
        $map = [];
        $data = preg_split('/\r\n|\r|\n/', $data);
        foreach ($data as $line) {
            if (strlen($line) > 0) {
                $map[] = str_split($line);
            }
        }
//make directions
        for ($y = 0; $y < count($map); $y++) {
            for ($x = 0; $x < count($map[0]); $x++) {
                $value = $map[$y][$x];
                switch ($value) {
                    case 'S':
                        $S = ['X' => $x, 'Y' => $y];
                        $map[$y][$x] = ['value' => $map[$y][$x], 'X' => $x, 'Y' => $y];
                        break;
                    case '|':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y - 1 . $x => ['Y' => $y + 1, 'X' => $x],
                            $y + 1 . $x => ['Y' => $y - 1, 'X' => $x],
                            'X' => $x,
                            'Y' => $y
                        ];
                        break;
                    case '-':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y . $x - 1 => ['Y' => $y, 'X' => $x + 1],
                            $y . $x + 1 => ['Y' => $y, 'X' => $x - 1],
                            'X' => $x,
                            'Y' => $y
                        ];
                        break;
                    case 'L':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y - 1 . $x => ['Y' => $y, 'X' => $x + 1],
                            $y . $x + 1 => ['Y' => $y - 1, 'X' => $x],
                            'X' => $x,
                            'Y' => $y
                        ];
                        break;
                    case 'J':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y - 1 . $x => ['Y' => $y, 'X' => $x - 1],
                            $y . $x - 1 => ['Y' => $y - 1, 'X' => $x],
                            'X' => $x,
                            'Y' => $y
                        ];
                        break;
                    case '7':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y . $x - 1 => ['Y' => $y + 1, 'X' => $x],
                            $y + 1 . $x => ['Y' => $y, 'X' => $x - 1],
                            'X' => $x,
                            'Y' => $y
                        ];
                        break;
                    case 'F':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y . $x + 1 => ['Y' => $y + 1, 'X' => $x],
                            $y + 1 . $x => ['Y' => $y, 'X' => $x + 1],
                            'X' => $x,
                            'Y' => $y
                        ];
                        break;
                    default:
                        $map[$y][$x] = ['value' => $map[$y][$x], 'X' => $x, 'Y' => $y];
                        break;
                }
            }
        }


        //rest
        $next = [];
        $neighbors[] = ['Y' => $S['Y'] + 1, 'X' => $S['X']];
        $neighbors[] = ['Y' => $S['Y'] - 1, 'X' => $S['X']];
        $neighbors[] = ['Y' => $S['Y'], 'X' => $S['X'] + 1];
        $neighbors[] = ['Y' => $S['Y'], 'X' => $S['X'] - 1];

        foreach ($neighbors as $neighbor) {
            $n = $map[$neighbor['Y']][$neighbor['X']][$S['Y'] . $S['X']] ?? null;

            if ($n != null) {
                $next[] = ['Y' => $neighbor['Y'], 'X' => $neighbor['X']];
            }
        }


        $currentLocation = $S;

        $nextLocation = $next[0];
        $steps = 0;
        $path = [];


        while (true) {
            $currentValue = $map[$currentLocation['Y']][$currentLocation['X']]['value'];
            $path[$currentLocation['Y']] [$currentLocation['X']] = $steps;
            $nextValue = $map[$nextLocation['Y']][$nextLocation['X']]['value'];
            $steps++;
            $from = $currentLocation['Y'] . $currentLocation['X'];
            $currentLocation = $nextLocation;
            $Y = $nextLocation['Y'];
            $X = $nextLocation['X'];
            if ($map[$Y][$X]['value'] === 'S') {
                break;
            }
            $nextLocation = $map[$Y][$X][$from];
        }

        $tiles = 0;
        foreach ($map as $line) {
            foreach ($line as $item) {
                $x = $item['X'];
                $y = $item['Y'];

                $stepCount = $path[$y][$x] ?? false;
                $isOnPath = (bool)$stepCount;
                if ($isOnPath) {
                    echo "<strong>{$item['value']}</strong>";
                } else {
                    $crossings = 0;
                    for ($i = $x + 1; $i < count($line); $i++) {
                        $stepCount = $path[$y][$i] ?? false;
                        $isOnPath = (bool)$stepCount;
                        if ($stepCount === 0) {
                            $isOnPath = true;
                        }

                        $stepCountBelow = $path[$y + 1][$i] ?? false;
                        $belowOnPath = (bool)$stepCountBelow;
                        if ($isOnPath && $belowOnPath) {
                            if (abs($stepCount - $stepCountBelow) === 1) {
                                $crossings += $stepCount - $stepCountBelow;
                            }
                        }
                    }


                    if ($crossings != 0) {
                        echo "<strong style=\"color:red;\">{$item['value']}</strong>";
                        $tiles++;
                    } else {
                        echo "{$item['value']}";
                    }
                }
            }
            echo "\n";
        }

        var_dump($tiles);
    }
}