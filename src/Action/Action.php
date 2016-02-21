<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

abstract class Action
{
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
