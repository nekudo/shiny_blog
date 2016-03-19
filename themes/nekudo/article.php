<article class="article">
    <header>
        <h1><?php echo $article->getTitle(); ?></h1>
        <div class="article-meta">
            published at
            <time datetime="<?php echo $article->getDate(); ?>" pubdate>
                <?php echo $article->getDate(); ?>
            </time>
            by <?php echo $article->getAuthor(); ?>
        </div>
    </header>
    <div class="entry-content">
        <?php echo $article->getContent(); ?>
    </div>
    <footer>
        <?php if ($article->hasCategories()): ?>
            <div class="categories">
            <div class="hl-sm">Categories</div>
            <?php foreach ($article->getCategories() as $category): ?>
                <a href="<?php echo $category['link']; ?>" class="btn"><?php echo $category['name']; ?></a>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </footer>
</article>
