<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->getTitle(); ?></title>
        <meta name="robots" content="<?php echo $this->getIndex(); ?>" />
        <meta name="description" content="<?php echo $this->getDescription(); ?>">
        <link rel="stylesheet" href="/themes/nekudo/css/nekudo.css">
    </head>
    <body>
        <div class="content">
            <?php echo $template; ?>
        </div>
    </body>
</html>
