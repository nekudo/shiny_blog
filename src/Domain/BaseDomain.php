<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

class BaseDomain
{
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
