<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

class Article
{
    public function __invoke(array $arguments)
    {
        var_dump($arguments);
    }
}
