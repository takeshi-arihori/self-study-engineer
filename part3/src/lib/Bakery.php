<?php


const SPLIT_LENGTH = 2;
const TAX = 10;
const BREADS = [
    1 => 100,
    2 => 120,
    3 => 150,
    4 => 250,
    5 => 80,
    6 => 120,
    7 => 100,
    8 => 180,
    9 => 50,
    10 => 300
];

// @return array [商品番号 => 販売個数, 商品番号 => 販売個数, ...]
function chunkInput(array $argv): array // メソッド名が重複しないように変更。配列を引数で受け取れるように変更
{
    $argument = array_slice($argv, 1);
    $args = array_chunk($argument, SPLIT_LENGTH);
    $sales = [];
    foreach ($args as $arg) {
        $sales[$arg[0]] = (int) $arg[1];
    }
    return $sales;
}

function calculateSales(array $sales): int
{
    $sum = 0;

    foreach ($sales as $number => $unitsSold) {
        $sum += BREADS[$number] * (int) $unitsSold;
    }

    return (int) $sum * (100 + TAX) / 100;
}

function getNumbersOfMaxUnitsSold(array $sales): array
{
    if (empty($sales)) { // テスト実行時にエラーが起きないよう、入力が空の時でも動作するよう処理を追加
        return [];
    }

    $max = max(array_values($sales));
    return array_keys($sales, $max);
}

function getNumbersOfMinUnitsSold(array $sales): array
{
    if (empty($sales)) { // テスト実行時にエラーが起きないよう、入力が空の時でも動作するよう処理を追加
        return [];
    }

    $min = min(array_values($sales));
    return array_keys($sales, $min);
}

function displayResult(array ...$results): void // メソッド名が重複しないように変更
{
    foreach ($results as $result) {
        echo implode(' ', $result) . PHP_EOL;
    }
}

$sales = chunkInput($_SERVER['argv']);
$salesAmount = calculateSales($sales);
$numbersOfMaxUnitsSold = getNumbersOfMaxUnitsSold($sales);
$numbersOfMinUnitsSold = getNumbersOfMinUnitsSold($sales);
displayResult([$salesAmount], $numbersOfMaxUnitsSold, $numbersOfMinUnitsSold);
