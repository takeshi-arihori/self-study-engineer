<?php

$i = 0;

while (true) {
    // 50より少なければ
    if ($i <= 50) {
        // 10ずつ増やす
        echo $i . PHP_EOL;
        $i += 10;
    } else {
        // loopを終了させる
        break;
    }
}
