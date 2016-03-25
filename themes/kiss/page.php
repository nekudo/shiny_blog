<article class="page">
    <?php if(!empty($page->getTitle())): ?>
        <h1><?php echo $page->getTitle(); ?></h1>
    <?php endif; ?>
    <div class="page-content">
        <?php echo $page->getContent(); ?>
    </div>
</article>
