<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <title>読書ログ登録</title>
</head>

<body>
    <h1>読書ログ</h1>
    <form action="create.php" method="post">
        <!-- エラー詳細を表示する -->
        <?php if (count($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div>
            <label for="title">書籍名</label>
            <input type="text" name="title" id="title" value="<?php echo $review['title'] ?>">
        </div>
        <div>
            <label for="author">著者名</label>
            <input type="text" name="author" id="author" value="<?php echo $review['author'] ?>">
        </div>
        <div>
            <label for="status">読書状況</label>
            <select name="status" id="status">
                <option value="" <?php echo $review['status'] === '' ? 'selected' : ''; ?>>選択してください</option>
                <option value="未読" <?php echo $review['status'] === '未読' ? 'selected' : ''; ?>>未読</option>
                <option value="読んでる" <?php echo $review['status'] === '読んでる' ? 'selected' : ''; ?>>読んでる</option>
                <option value="読了" <?php echo $review['status'] === '読了' ? 'selected' : ''; ?>>読了</option>
            </select>
        </div>
        <div>
            <label for="score">評価（5点満点の整数）</label>
            <input type="number" id="score" name="score" min="1" max="5" value="<?php echo $review['score'] ?>">
        </div>
        <div>
            <label for="summary">感想</label>
            <textarea name="summary" id="summary" value="<?php echo $review['summary'] ?>"></textarea>
        </div>
        <button type="submit">登録する</button>
    </form>
</body>

</html>