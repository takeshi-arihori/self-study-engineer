<?php
require __DIR__ . '/../vendor/autoload.php';

function dbConnect()
{
    // 環境変数を読み込む
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $dbHost = $_ENV['DB_HOST'];
    $dbUsername = $_ENV['DB_USERNAME'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbDatabase = $_ENV['DB_DATABASE'];

    $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);

    if (!$link) {
        echo 'Error: データベースに接続できませんでした' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    return $link;
}

function dropTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS companies';
    $results = mysqli_query($link, $dropTableSql);

    if ($results) {
        echo 'テーブルを削除しました' . PHP_EOL;
    } else {
        echo 'Error: テーブルの削除に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createTable($link)
{
    $createTable = <<<EOT
    CREATE TABLE companies (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        establishment_date DATE,
        founder VARCHAR(255),
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;
EOT;

    $results = mysqli_query($link, $createTable);

    if ($results) {
        echo 'テーブルを作成しました' . PHP_EOL;
    } else {
        echo 'Error: テーブルの作成に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

$link = dbconnect();

dropTable($link);

createTable($link);

mysqli_close($link);
