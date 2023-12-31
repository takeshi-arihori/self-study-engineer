<?php

// DBからリストを取得する
function listReviews($link)
{
    echo '登録されている読書ログを表示します' . PHP_EOL;

    // DBから取得
    $sql = 'SELECT id, title, author, status, score, summary FROM reviews';
    $results = mysqli_query($link, $sql);


    while ($review = mysqli_fetch_assoc($results)) {
        echo '書籍名 : ' . $review['title'] . PHP_EOL;
        echo '著者名 : ' . $review['author'] . PHP_EOL;
        echo '読書状況 : ' . $review['status'] . PHP_EOL;
        echo '評価 : ' . $review['score'] . PHP_EOL;
        echo '感想 : ' . $review['summary'] . PHP_EOL;
        echo '----------------------' . PHP_EOL;
    }

    mysqli_free_result($results);
}

function dbConnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    return $link;
}

function validate($review)
{
    $errors = []; // エラー内容を格納する配列

    // 書籍名が正しく入力されているかチェック
    if (!strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } else if (strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    }

    // 著者名(author)が正しく入力されているかチェック
    if (!strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    }

    // 読書状況(status)が正しく入力されているかチェック
    if (!in_array($review['status'], ['未読', '読んでる', '読了'])) {
        $errors['status'] = '読書状況は未読、読んでる、読了のいずれかを入力してください';
    }

    // 評価の数値が1以上5以下であるかチェック
    if ($review['score'] < 1 || $review['score'] > 5) {
        $errors['score'] = '評価は1〜5の整数を入力してください';
    }

    // 感想(summary)が正しく入力されているかチェック
    if (!strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください';
    } else if (strlen($review['summary']) > 1000) {
        $errors['summary'] = '感想は1000文字以内で入力してください';
    }

    return $errors;
}

function createReview($link)
{
    $review = [];

    echo PHP_EOL;
    echo '読書ログを登録します' . PHP_EOL;

    echo '書籍名:';
    $review['title'] = trim(fgets(STDIN));

    echo '著者名:';
    $review['author'] = trim(fgets(STDIN));

    echo '読書状況（未読,読んでる,読了）:';
    $review['status'] = trim(fgets(STDIN));

    echo '評価（5点満点の整数）:';
    $review['score'] = (int) trim(fgets(STDIN));

    echo '感想 :';
    $review['summary'] = trim(fgets(STDIN));

    // エラーチェック
    $validated = validate($review);
    // エラーがあれば表示して終了
    if (count($validated) > 0) {
        foreach ($validated as $error) {
            echo $error . PHP_EOL;
        }
        return;
    }

    $sql = <<<EOT
INSERT INTO reviews (
    title,
    author,
    status,
    score,
    summary
) VALUES (
    "{$review['title']}",
    "{$review['author']}",
    "{$review['status']}",
    "{$review['score']}",
    "{$review['summary']}"
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

$reviews = [];
$link = dbConnect();

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください(1,2,9) : ';

    $num = trim(fgets(STDIN));

    if ($num === '1') {
        createReview($link);
    } else if ($num === '2') {
        listReviews($link);
    } else if ($num === '9') {
        // アプリケーションを終了する
        mysqli_close($link);
        echo 'アプリケーションを終了します' . PHP_EOL;
        break;
    } else {
        echo '入力された値は選択肢にありません' . PHP_EOL;
    }
}
