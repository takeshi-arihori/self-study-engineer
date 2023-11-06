<a href="new.php">読書ログを登録する</a>
<main>
    <?php if (count($reviews) > 0) : ?>
        <?php foreach ($reviews as $review) : ?>
            <section>
                <h2><?php echo escape($review['title']) ?></h2>
                <div>
                    <?php echo escape($review['author']) ?>&nbsp;/&nbsp;
                    <?php echo escape($review['status']) ?>&nbsp;/&nbsp;
                    <?php echo escape($review['score']) ?>&nbsp;/&nbsp;
                </div>
                <p>
                    <?php echo nl2br(escape($review['summary']), false) ?>
                </p>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>まだ読書ログが登録されていません。</p>
    <?php endif; ?>
</main>