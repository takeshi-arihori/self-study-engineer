<?php

function dbConnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

    if (!$link) {
        echo 'データベースに接続できませんでした' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    echo 'データベースに接続できました。' . PHP_EOL;

    return $link;
}

function createReview($link)
{
    echo PHP_EOL;
    echo '読書ログを登録します' . PHP_EOL;

    echo '書籍名:';
    $title = trim(fgets(STDIN));

    echo '著者名:';
    $author = trim(fgets(STDIN));

    echo '読書状況（未読,読んでる,読了）:';
    $status = trim(fgets(STDIN));

    echo '評価（5点満点の整数）:';
    $score = (int) trim(fgets(STDIN));

    echo '感想 :';
    $summary = trim(fgets(STDIN));

    echo ' 登録が完了しました' . PHP_EOL . PHP_EOL;
    echo PHP_EOL;

    $sql = <<<EOT
INSERT INTO reviews (
    title,
    author,
    status,
    score,
    summary
) VALUES (
    "{$title}",
    "{$author}",
    "{$status}",
    $score,
    "{$summary}"
)
EOT;

    $result = mysqli_query($link, $sql);

    if ($result) {
        echo 'データを追加しました' . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}


function listReviews($reviews)
{
    echo PHP_EOL;
    // 読書ログを表示する
    echo '登録されている読書ログを表示します' . PHP_EOL;

    foreach ($reviews as $review) {
        echo '書籍名:' . $review['title'] . PHP_EOL;
        echo '著者名:' . $review['author'] . PHP_EOL;
        echo '読書状況（未読,読んでる,読了）:' . $review['status'] . PHP_EOL;
        echo '評価（5点満点の整数）:' . $review['score'] . PHP_EOL;
        echo '感想 :' . $review['summary'] . PHP_EOL;
        echo '-------------' . PHP_EOL;
    }
    echo PHP_EOL;
}


$link = dbConnect();

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください(1,2,9) : ';

    $num = trim(fgets(STDIN));
    // 大文字と小文字を区別しない
    $num = strtolower($num);
    // 全角と半角両方受け入れる
    $num = mb_convert_kana($num, 'a', 'UTF-8');


    if ($num === '1') {
        createReview($link);
    } else if ($num === '2') {
        listReviews($reviews);
    } else if ($num === '9') {
        // アプリケーションを終了する
        mysqli_close($link);
        echo 'アプリケーションを終了します' . PHP_EOL;
        break;
    } else {
        echo '入力された値は選択肢にありません' . PHP_EOL;
    }
}
