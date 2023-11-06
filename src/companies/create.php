<?php

require_once __DIR__ . '/../lib/mysqli.php';

function createCompany($link, $company)
{
    $sql = <<<EOT
    INSERT INTO companies (
        name,
        establishment_date,
        founder
    ) VALUES (
        "{$company['name']}",
        "{$company['establishment_date']}",
        "{$company['founder']}"
    )
EOT;

    $results = mysqli_query($link, $sql);
    if (!$results) {
        error_log('Error: fail to create company');
        error_log('Debugging Error: ' . mysqli_error($link));
    }
}

function validate($company)
{
    $errors = [];

    // 会社名が正しく入力されているかチェック
    if (!strlen($company['name'])) {
        $errors['name'] = '会社名を入力してください';
    } else if (strlen($company['name'] > 255)) {
        $errors['name'] = '会社名は255文字以内で入力してください';
    }

    // 設立日が正しく入力されているかチェック
    // 日付を分割する
    $dates = explode('-', $company['establishment_date']);

    if (!strlen($company['establishment_date'])) {
        $errors['establishment_date'] = '設立日を入力してください';
    } else if (count($dates) !== 3) {
        $errors['establishment_date'] = '設立日を正しい形式で入力してください';
    } else if (!checkdate($dates[1], $dates[2], $dates[0])) {
        $errors['establishment_date'] = '設立日を正しい形式で入力してください';
    }

    // 代表者名が正しく入力されているかチェック
    if (!strlen($company['founder'])) {
        $errors['founder'] = '代表者名を入力してください';
    } else if (strlen($company['founder']) > 100) {
        $errors['founder'] = '代表者名は100文字以内で入力してください';
    }

    return $errors;
}

// HTTPメソッドがPOSTだったら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTされた会社情報を変数に格納する
    $company = [
        'name' => $_POST['name'],
        'establishment_date' => $_POST['establishment_date'],
        'founder' => $_POST['founder'],
    ];
    // バリデーションする
    $errors = validate($company);
    // バリデーションエラーがなければ
    if (!count($errors)) {
        $link = dbConnect();
        createCompany($link, $company);
        mysqli_close($link);
        // index.phpにredirectする
        // header("Location: index.php");
    }
}

include 'views/new.php';
