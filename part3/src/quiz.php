<?php

// チャンネル：数値を指定すること。1〜12の範囲とする（1ch〜12ch）
// 視聴分数：分数を指定すること。1〜1440の範囲とする

$channelAndMinuteWatched = []; // テレビのチャンネルと視聴分数を格納する配列

$flag = false;

// バリデーション
function validate($tvChannel, $minitesWatched)
{
    if ($tvChannel < 1 || $tvChannel > 12) {
        echo 'チャンネルは1〜12の範囲で入力してください' . PHP_EOL;
        return false;
    }
    if ($minitesWatched < 1 || $minitesWatched > 1440) {
        echo '視聴分数は1〜1440の範囲で入力してください' . PHP_EOL;
        return false;
    }
    return true;
}

while (!$flag) {
    // チャンネル・視聴分数の入力を受け取る
    echo 'チャンネルを入力してください' . PHP_EOL;
    $tvChannel = trim(fgets(STDIN)) . PHP_EOL;
    echo '視聴分数を入力してください' . PHP_EOL;
    $minitesWatched = trim(fgets(STDIN)) . PHP_EOL;

    // 型変換 string -> int
    $tvChannel = (int) $tvChannel;
    $minitesWatched = (int) $minitesWatched;

    // validateで入力値のチェック
    if (!validate($tvChannel, $minitesWatched)) {
        echo '入力値が不正です。再度入力してください' . PHP_EOL;
        continue;
    }

    // 配列に格納
    $channelAndMinuteWatched[] = [
        'channel' => $tvChannel,
        'minitesWatched' => $minitesWatched
    ];

    // 続けて入力するかどうかを確認する
    echo '続けて入力しますか？（y/n）' . PHP_EOL;
    // strtolowerを使用し全て小文字にする
    $continue = strtolower(trim(fgets(STDIN)));
    // yが入力されたらループを続け、nが入力されたらループを抜ける
    if ($continue === 'n') {
        break;
    }
}

// loopが終了した時点で出力する
// total視聴時間も出力する(数値に変換)
$totalMinitesWatched = 0;
echo 'チャンネル別視聴分数ランキング' . PHP_EOL;
foreach ($channelAndMinuteWatched as $value) {
    $totalMinitesWatched += $value['minitesWatched'];
    echo $value['channel'] . 'ch : ' . $value['minitesWatched'] . '分' . PHP_EOL;
}
echo '合計視聴時間：' . $totalMinitesWatched . '分' . PHP_EOL;
