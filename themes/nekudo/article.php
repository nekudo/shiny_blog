<article>
    <header>
        <h2><?php echo $article->getTitle(); ?></h2>
        <div class="entry-meta">
            <?php echo $article->getDate(); ?> / by
            <?php echo $article->getAuthor(); ?>
        </div>  
    </header>
    <div class="entry-content">
        <?php echo $article->getContent(); ?>
    </div>
    <footer>
        <?php if ($article->hasCategories()): ?>
            <div class="categories">
            <?php foreach ($article->getCategories() as $category): ?>
                <a href="<?php echo $category['link']; ?>"><?php echo $category['name']; ?></a>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </footer>
</article>