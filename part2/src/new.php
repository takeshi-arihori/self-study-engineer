<?php

$review = [
    'title' => '',
    'author' => '',
    'status' => '',
    'score' => '',
    'summary' => '',
];

$errors = [];

$title = '読書ログ登録';
$content = __DIR__ . '/views/new.php';
include 'views/layout.php';
