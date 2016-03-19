<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->getTitle(); ?></title>
        <meta name="robots" content="<?php echo $this->getIndex(); ?>" />
        <meta name="description" content="<?php echo $this->getDescription(); ?>">
        <link rel="stylesheet" href="/themes/nekudo/css/nekudo.css">
        <link rel="stylesheet" href="/themes/nekudo/css/prism.css">
    </head>
    <body>
        <nav class="topnav">
            <ul>
                <li class="first"><a href="/">nekudo.com</a></li>
                <li<?php if($navActive === 'blog'): ?> class="active"<?php endif; ?>><a href="/blog">Blog</a></li>
                <li<?php if($navActive === 'imprint'): ?> class="active"<?php endif; ?>><a href="/imprint">Imprint</a></li>
                <li><a href="https://github.com/nekudo">Github</a></li>
                <li class="last"><a href="https://twitter.com/lemmingzshadow">Twitter</a></li>
            </ul>
        </nav>
        <div class="content">
            <?php echo $template; ?>
        </div>
        <div class="footer">
            <p>nekudo.com - keep it simple :)</p>
        </div>
        <script src="/themes/nekudo/js/prism.js"></script>
    </body>
</html>
