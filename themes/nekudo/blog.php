<?php foreach ($articles as $article): ?>
    <article>
        <header>
            <h2>
                <a href="<?php echo $article->getUrl(); ?>">
                    <?php echo $article->getTitle(); ?>
                </a>
            </h2>
            <div class="article-extract">
                <?php echo $article->getExcerpt(true); ?>
            </div>
        </header>
    </article>
<?php endforeach; ?>
