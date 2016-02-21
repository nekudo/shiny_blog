<html>
<head>
<?php if (isset($meta->title)): ?>
    <title><?php echo $meta->title; ?></title>
<?php endif; ?>
</head>
<body>
    <div class="content">
        <?php echo $template; ?>
    </div>
</body>
</html>