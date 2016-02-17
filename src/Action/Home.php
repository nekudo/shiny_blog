<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

class Home
{
    public function __invoke(array $arguments)
    {
        echo "home";
    }
}
