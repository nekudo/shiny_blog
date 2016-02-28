<div class="articles">
    <?php if (empty($articles)): ?>
        <p>Sorry - no articles found.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <article class="excerpt">
                <header>
                    <h2>
                        <a href="<?php echo $article->getUrl(); ?>">
                            <?php echo $article->getTitle(); ?>
                        </a>
                    </h2>
                </header>
                <div class="article-excerpt">
                    <?php echo $article->getExcerpt(true); ?>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (!empty($urlPrevPage) || !empty($urlNextPage)): ?>
<nav>
    <ul class="pagination">
        <?php if (!empty($urlPrevPage)): ?>
        <li class="previous-page">
            <a href="<?php echo $urlPrevPage; ?>">
                Previous Page
            </a>
        </li>
        <?php endif; ?>
        <?php if (!empty($urlNextPage)): ?>
        <li class="next-page">
            <a href="<?php echo $urlNextPage; ?>">
                Next Page
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>