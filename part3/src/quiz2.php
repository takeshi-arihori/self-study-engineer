<?php

// ◯お題
// あなたは小さなパン屋を営んでいました。一日の終りに売上の集計作業を行います。
// 商品は10種類あり、それぞれ金額は以下の通りです（税抜）。

// ①100
// ②120
// ③150
// ④250
// ⑤80
// ⑥120
// ⑦100
// ⑧180
// ⑨50
// ⑩300

// 一日の売上の合計（税込み）と、販売個数の最も多い商品番号と販売個数の最も少ない商品番号を求めてください。

// ◯インプット
// 入力は以下の形式で与えられます。

// 販売した商品番号 販売個数 販売した商品番号 販売個数 ...

// ※ただし、販売した商品番号は1〜10の整数とする。

// ◯アウトプット

// 売上の合計
// 販売個数の最も多い商品番号
// 販売個数の最も少ない商品番号

// ※ただし、税率は10%とする。
// ※また、販売個数の最も多い商品と販売個数の最も少ない商品について、販売個数が同数の商品が存在する場合、それら全ての商品番号を記載すること。

// ◯インプット例

// 1 10 2 3 5 1 7 5 10 1

// ◯アウトプット例

// 2464
// 1
// 5 10

// ◯実行コマンド例
// php quiz2.php 1 10 2 3 5 1 7 5 10 1

const TAX_RATE = 0.1; // 10%
const SPLIT_LENGTH = 2;

const PRODUCTS = [
    1 => 100,
    2 => 120,
    3 => 150,
    4 => 250,
    5 => 80,
    6 => 120,
    7 => 100,
    8 => 180,
    9 => 50,
    10 => 300,
];

function getInput(): array
{
    $inputs = array_slice($_SERVER['argv'], 1);
    // var_dump($inputs);
    return array_chunk($inputs, SPLIT_LENGTH);
}

// 入力値を商品番号ごとにグルーピングする
function groupProductNumberAndQuantity($inputs): array
{
    $productNumberAndQuantity = [];

    foreach ($inputs as $input) {
        $number = $input[0];
        $quantity = $input[1];

        if (array_key_exists($number, $productNumberAndQuantity)) {
            $productNumberAndQuantity[$number] += $quantity;
        } else {
            $productNumberAndQuantity[$number] = $quantity;
        }
    }

    return $productNumberAndQuantity;
}

// 一日の合計売上を算出
function calculateDailySalesTotal(array $productNumberAndQuantity): int
{
    $dailySalesTotal = 0;

    foreach ($productNumberAndQuantity as $number => $quantity) {
        // 各商品の税別合計を算出
        $totalPrice = PRODUCTS[$number] * $quantity;
        $dailySalesTotal += $totalPrice;
    }

    // 税率をかけて税込み合計を算出
    return $dailySalesTotal * (1 + TAX_RATE);
}

// 販売個数の最も多い商品番号を算出
function findMaxSalesProductNumber(array $productNumberAndQuantity): array
{
    $max = max(array_values($productNumberAndQuantity));
    return array_keys($productNumberAndQuantity, $max);
}

// 販売個数の最も少ない商品番号を算出
function findMinSalesProductNumber(array $productNumberAndQuantity): array
{
    $min = min(array_values($productNumberAndQuantity));
    return array_keys($productNumberAndQuantity, $min);
}

// 必要なデータの算出
function display(array $productNumberAndQuantity): void
{
    // 一日の売上合計を算出: 売上の合計（税込み）-> 1*10*100 + 2*3*120 + 5*1*80 + .... -> 2464
    $dailySalesTotal = calculateDailySalesTotal($productNumberAndQuantity);
    echo $dailySalesTotal . PHP_EOL;

    // 販売個数の最も多い商品番号 -> [1, 10] -> 1
    $maxSalesProductNumber = findMaxSalesProductNumber($productNumberAndQuantity);
    var_export($maxSalesProductNumber);

    // 販売個数の最も少ない商品番号 -> [[5, 1], [10, 1]] -> 5 10
    $minSalesProductNumber = findMinSalesProductNumber($productNumberAndQuantity);
    var_export($minSalesProductNumber);
}

// コマンドラインからinputを取得
$inputs = getInput();

// 取得したデータをそれぞれの商品番号と個数に分ける
// 例: 1 10 2 3 5 1 7 5 10 1 -> [[1, 10], [2, 3],[5, 1],[7, 5],[10, 1]]
$productNumberAndQuantity = groupProductNumberAndQuantity($inputs);

// 必要なデータを算出
display($productNumberAndQuantity);
