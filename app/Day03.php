<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Day03
{
    public function run(): void
    {
        $client = new Client();

        $jar = CookieJar::fromArray([
            'session' => $_ENV['AOC_COOKIE']
        ], 'adventofcode.com');
        $response = $client->request('GET', 'https://adventofcode.com/2023/day/3/input', ['cookies' => $jar]);
        echo '<pre>';
        $data = (string)$response->getBody();

//        $data = str_split($data);
//        $test = [];
//        foreach ($data as $letter) {
//            $test[$letter]++;
//        }
//        var_dump($test);
//        die;
//        $data = '467..114..
//...*......
//..35..633.
//......#...
//617*......
//.....+.58.
//..592.....
//......755.
//...$.*....
//.664.598..
//';
//        $data = '........
//.24..4..
//......*.
//';
        $data = preg_split('/\r\n|\r|\n/', $data);
        $partSum = 0;
        $symbols = '&/#!@$%^+-=';
        $stars = [];
        foreach ($data as $key => $line) {
//            if ($key < 139) {
//                continue;
//            }
//            $debugLine = $line;
//            $debugLine = str_replace(str_split($symbols), '.', $debugLine);
//            $debugLine = str_replace('*', "<strong>*</strong>", $debugLine);

            $digitsAndSpaces = preg_replace('/\D/', ' ', $line);
            if (strlen($line) <= 0) {
                break;
            }
//            var_dump(count($data));
//            var_dump($data[count($data) - 2]);
//            die;
            preg_match_all('(\d+)', $digitsAndSpaces, $matches);
//            echo "\n";
//            echo "\n";
//            echo($data[$key - 1]);
//            echo "\n";
//
//
//            echo($data[$key]);
//            echo "\n";
//            echo($data[$key + 1]);
//            echo "\n";
//            var_dump($matches[0]);
            $prev = 0;
            foreach ($matches[0] as $number) {
                $neighbors = '';
                $start = strpos($line, $number, $prev);
                $end = $start + strlen($number);
                $prev = $end;

                if ($key > 0) {
                    if ($start > 0) {
                        $neighbors = substr($data[$key - 1], $start - 1, strlen($number) + 2);
                    } else {
                        $neighbors = substr($data[$key - 1], $start, strlen($number) + 1);
                    }
                    foreach (str_split($neighbors) as $i => $n) {
                        if ($n === '*') {
                            $x = $key - 1;
                            $y = $start + $i - 1;
                            $stars[$x][$y][] = $number;
                        }
                    }
                }
                if ($start > 0) {
                    $neighbors = substr($data[$key], $start - 1, 1);
                    if ($neighbors === '*') {
                        $x = $key;
                        $y = $start - 1;
                        $stars[$x][$y][] = $number;
                    }
                }
                $neighbors = substr($data[$key], $end, 1);
                if ($neighbors === '*') {
                    $x = $key;
                    $y = $end;
                    $stars[$x][$y][] = $number;
//                    var_dump($x, $y, $neighbors, str_split($line)[$y]);
//                    var_dump($stars[$x]);
                }
                $dataEnd = count($data) - 2;
                if ($key < $dataEnd) {
                    if ($start > 0) {
                        $neighbors = substr($data[$key + 1], $start - 1, strlen($number) + 2);
                    } else {
                        $neighbors = substr($data[$key + 1], $start, strlen($number) + 1);
                    }

                    if (!($neighbors)) {
                        var_dump($data[139]);
                        var_dump($key, $neighbors, $line, $number);
                    }
                    foreach (str_split($neighbors) as $i => $n) {
                        if ($n === '*') {
                            $x = $key + 1;
                            $y = $start + $i - 1;
                            $stars[$x][$y][] = $number;
//                            var_dump($x, $y, $neighbors, str_split($data[$key + 1])[$y]);
                        }
                    }
                }


//                if (!strpbrk($neighbors, '*')) {
//                    echo " $number: $neighbors";
//                    $debugLine = str_replace($number, str_repeat('.', strlen($number)), $debugLine);
//pierakstam neighbor * adresi $star[x][y]=[number,number];

//                    $debugNumber .= $number . "|";
//                $partSum += (int)$number;
//                } else {
////                    echo " nota$number: $neighbors";
//                }
            }
//            echo "$debugLine\n";
        }
//            var_dump($partSum);
//        var_dump($stars);
        foreach ($stars as $star) {
            foreach ($star as $pair) {
                if (count($pair) > 1) {
                    $partSum += array_product($pair);
                }
            }
        }
        echo "$partSum\n";
    }


}