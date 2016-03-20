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

    /**
     * Converts url-path to absolut url.
     *
     * @param  string $path
     * @return string
     */
    protected function getUrlFromPath(string $path) : string
    {
        $host = $_SERVER['HTTP_HOST'];
        $schema = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
        $path = ltrim($path, '/');
        return $schema . $host . '/' . $path;
    }
}
