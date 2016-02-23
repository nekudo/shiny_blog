<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

abstract class BaseAction
{
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
