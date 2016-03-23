<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog;

use Nekudo\ShinyBlog\Core\Psr4Autoloader;

$appRoot = __DIR__ . '/../src/';
$vendorRoot = __DIR__ . '/../vendor/';

require_once $appRoot . 'Core/Autoloader.php';
require_once $vendorRoot . 'nikic/fast-route/src/functions.php';
require_once $vendorRoot . 'erusev/parsedown/Parsedown.php';
require_once $vendorRoot . 'erusev/parsedown-extra/ParsedownExtra.php';

$loader = new Psr4Autoloader;
$loader->register();
$loader->addNamespace('FastRoute\\', __DIR__ . '/../vendor/nikic/fast-route/src/');
$loader->addNamespace('Nekudo\\ShinyBlog\\', __DIR__ . '/../src/');

$config = require 'config.php';
$blog = new ShinyBlog($config);
$blog->run();
