<?php
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>読書ログ登録</title>
</head>

<body>
    <h1>読書ログ</h1>
    <form action="create.php" method="post">
        <div>
            <label for="title">書籍名</label>
            <input type="text" id="title" name="title">
        </div>
        <div>
            <label for="author">著者名</label>
            <input type="text" id="author" name="author">
        </div>
        <div>
            <label for="status">読書状況</label>
            <select name="status" id="status">
                <option value="未読">未読</option>
                <option value="読んでる">読んでる</option>
                <option value="読了">読了</option>
            </select>
        </div>
        <div>
            <label for="score">評価（5点満点の整数）</label>
            <input type="number" id="score" name="score" min="1" max="5">
        </div>
        <div>
            <label for="summary">感想</label>
            <textarea name="summary" id="summary"></textarea>
        </div>
        <button type="submit">登録する</button>
    </form>
</body>

</html>