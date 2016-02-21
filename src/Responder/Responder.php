<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

class Responder
{
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
