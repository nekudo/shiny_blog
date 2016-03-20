<section class="blog">
    <?php if ($showTitle === true): ?>
        <h1>Blog <small>Project news and web-development articles</small></h1>
    <?php endif; ?>
    <?php if (empty($articles)): ?>
        <p>Sorry - no articles found.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <article class="excerpt">
                <header>
                    <h2><a href="<?php echo $article->getUrl(); ?>"><?php echo $article->getTitle(); ?></a></h2>
                    <div class="article-meta">
                        published at
                        <time datetime="<?php echo $article->getDate(); ?>" pubdate>
                            <?php echo $article->getDate(); ?>
                        </time>
                    </div>
                </header>
                <blockquote class="article-excerpt">
                    <?php echo $article->getExcerpt(true); ?>
                </blockquote>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($urlPrevPage) || !empty($urlNextPage)): ?>
        <nav class="pagination">
            <?php if (!empty($urlPrevPage)): ?>
                <a class="previous-page" href="<?php echo $urlPrevPage; ?>">
                    &laquo; Previous Page
                </a>
            <?php endif; ?>
            <?php if (!empty($urlNextPage)): ?>
                <a class="next-page" href="<?php echo $urlNextPage; ?>">
                    Next Page &raquo;
                </a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</section>
