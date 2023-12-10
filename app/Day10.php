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
        $data2 = '..F7.
.FJ|.
SJ.L7
|F--J
LJ...
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
                        $map[$y][$x] = ['value' => $map[$y][$x]];
                        break;
                    case '|':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y - 1 . $x => ['Y' => $y + 1, 'X' => $x],
                            $y + 1 . $x => ['Y' => $y - 1, 'X' => $x]
                        ];
                        break;
                    case '-':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y . $x - 1 => ['Y' => $y, 'X' => $x + 1],
                            $y . $x + 1 => ['Y' => $y, 'X' => $x - 1]
                        ];
                        break;
                    case 'L':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y - 1 . $x => ['Y' => $y, 'X' => $x + 1],
                            $y . $x + 1 => ['Y' => $y - 1, 'X' => $x]
                        ];
                        break;
                    case 'J':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y - 1 . $x => ['Y' => $y, 'X' => $x - 1],
                            $y . $x - 1 => ['Y' => $y - 1, 'X' => $x]
                        ];
                        break;
                    case '7':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y . $x - 1 => ['Y' => $y + 1, 'X' => $x],
                            $y + 1 . $x => ['Y' => $y, 'X' => $x - 1]
                        ];
                        break;
                    case 'F':
                        $map[$y][$x] = [
                            'value' => $map[$y][$x],
                            $y . $x + 1 => ['Y' => $y + 1, 'X' => $x],
                            $y + 1 . $x => ['Y' => $y, 'X' => $x + 1]
                        ];
                        break;
                    default:
                        $map[$y][$x] = ['value' => $map[$y][$x]];
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
//        var_dump($next);

        $currentLocation = $S;
//        var_dump($S);
//        var_dump($next);
        $nextLocation = $next[0];
        $steps = 0;
        $path = '';
//        var_dump($map[0]);

        while (true) {
//            var_dump("current", $currentLocation);
//            var_dump("next", $nextLocation);

            $currentValue = $map[$currentLocation['Y']][$currentLocation['X']]['value'];
            $path .= $currentValue;
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
//            var_dump("current", $currentLocation);
//            var_dump("next", $nextLocation);


//            break;
        }
        var_dump($steps / 2);
    }
}