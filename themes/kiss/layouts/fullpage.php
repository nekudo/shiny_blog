<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->getTitle(); ?></title>
    <meta name="robots" content="<?php echo $this->getIndex(); ?>" />
    <meta name="description" content="<?php echo $this->getDescription(); ?>">
    <link rel="stylesheet" href="/themes/kiss/css/kiss.css">
</head>
<body class="fullpage">
    <?php echo $template; ?>
</body>
</html>
