<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require 'config.php';
$blog = new ShinyBlog($config);
$blog->run();