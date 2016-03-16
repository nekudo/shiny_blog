<div class="article">
    <?php echo $article->getContent(); ?>
</div>
<?php if ($article->hasCategories()): ?>
    <div class="categories">
    <?php foreach ($article->getCategories() as $category): ?>
        <a href="<?php echo $category['link']; ?>"><?php echo $category['name']; ?></a>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
