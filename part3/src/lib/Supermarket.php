<?php

/**
 * ◯お題
 * スーパーで買い物したときの支払金額を計算するプログラムを書きましょう。
 * 以下の商品リストがあります。先頭の数字は商品番号です。金額は税抜です。
 *
 * 1. 玉ねぎ 100円
 * 2. 人参 150円
 * 3. りんご 200円
 * 4. ぶどう 350円
 * 5. 牛乳 180円
 * 6. 卵 220円
 * 7. 唐揚げ弁当 440円
 * 8. のり弁 380円
 * 9. お茶 80円
 * 10. コーヒー 100円
 *
 * また、以下の条件を満たすと割引されます。
 *
 * a. 玉ねぎは3つ買うと50円引き
 * b. 玉ねぎは5つ買うと100円引き
 * c. 弁当と飲み物を一緒に買うと20円引き（ただし適用は一組ずつ）
 * d. お弁当は20〜23時はタイムセールで半額
 *
 * 合計金額（税込み）を求めてください。
 *
 * ◯仕様
 * 金額を計算するcalc関数を定義してください。
 * calcメソッドは「購入時刻 商品番号 商品番号 商品番号 ...」を引数に取り、合計金額（税込み）を返します。
 * 購入時刻：HH:MM形式（例. 20:00）とし、商品番号は1〜10の整数とします。
 * 同時に買える商品は20個までです。また、購入時刻は9〜23時です。
 *
 * ◯実行例
 * calc('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10])  //=> 1298
 *
 */



// 税
const TAX = 10;

// 玉ねぎの個数と割引額
const FIRST_ONION_DISCOUNT_NUMBER = 3;
const FIRST_ONION_DISCOUNT_PRICE = 50;
const SECOND_ONION_DISCOUNT_NUMBER = 3;
const SECOND_ONION_DISCOUNT_PRICE = 50;

// 弁当とセットの割引額
const SET_DISCOUNT_PRICE = 20;

// 弁当の割引の開始時間
const LUNCHBOX_DISCOUNT_START_TIME = '20:00';

// プロダクト一覧
const PRICES = [
    // 玉ねぎ 100円
    1 => ['price' => 100, 'type' => ''],
    // 人参 150円
    2 => ['price' => 150, 'type' => ''],
    // りんご 200円
    3 => ['price' => 200, 'type' => ''],
    // ぶどう 350円
    4 => ['price' => 350, 'type' => ''],
    // 牛乳 180円
    5 => ['price' => 180, 'type' => 'drink'],
    // 卵 220円
    6 => ['price' => 220, 'type' => ''],
    // 唐揚げ弁当 440円
    7 => ['price' => 440, 'type' => 'lunchbox'],
    // のり弁 380円
    8 => ['price' => 380, 'type' => 'lunchbox'],
    // お茶 80円
    9 => ['price' => 80, 'type' => 'drink'],
    // コーヒー 100円
    10 => ['price' => 100, 'type' => 'drink']
];

// 合計金額の出力
function calculate(string $buyTime, array $items): int
{
    // 合計額
    $totalAmount = 0;
    // 弁当の数
    $lunchbox = 0;
    // 飲み物の数
    $drink = 0;
    // 弁当の合計金額
    $lunchboxAmount = 0;

    // 一旦合計だけを取得
    foreach ($items as $item) {
        $productPrice = PRICES[$item]['price'];
        $totalAmount += $productPrice;

        if (PRICES[$item]['type'] === 'drink') {
            $drink++;
        }

        if (PRICES[$item]['type'] === 'lunchbox') {
            $lunchbox++;
            $lunchboxAmount += PRICES[$item]['price'];
        }
    }

    // 玉ねぎの個数に応じて割引
    $totalAmount -= discountOnion(array_count_values($items)[1]);

    // 弁当と飲み物のセットがあるなら割引
    $totalAmount -= discountSet($drink, $lunchbox);

    // 20:00 ~ 23:00ならタイムセール
    $totalAmount -= discountLunchBox($buyTime, $lunchboxAmount);

    // 税込合計金額
    return (int)$totalAmount * (TAX + 100) / 100;
}


//  * a. 玉ねぎは3つ買うと50円引き
//  * b. 玉ねぎは5つ買うと100円引き
function discountOnion(int $number): int
{
    $discount = 0;
    if ($number >= SECOND_ONION_DISCOUNT_NUMBER) {
        $discount = SECOND_ONION_DISCOUNT_PRICE;
    } elseif ($number >= FIRST_ONION_DISCOUNT_NUMBER) {
        $discount = FIRST_ONION_DISCOUNT_PRICE;
    }
    return $discount;
}


// 弁当と飲み物を一緒に買うと20円引き（ただし適用は一組ずつ）
function discountSet(int $drinkNumber, int $lunchboxNumber): int
{
    return SET_DISCOUNT_PRICE * min([$drinkNumber, $lunchboxNumber]);
}

// お弁当は20〜23時はタイムセールで半額
function discountLunchBox(string $buyTime, int $lunchboxAmount)
{
    if (strtotime(LUNCHBOX_DISCOUNT_START_TIME) > strtotime($buyTime)) {
        return 0;
    }
    return (int)$lunchboxAmount / 2;
}
