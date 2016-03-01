<html>
<head>
    <title><?php echo $this->getTitle(); ?></title>
    <meta name="robots" content="<?php echo $this->getIndex(); ?>" />
    <meta name="description" content="<?php echo $this->getDescription(); ?>">
</head>
<body>
    <div class="content">
        <?php echo $template; ?>
    </div>
</body>
</html>