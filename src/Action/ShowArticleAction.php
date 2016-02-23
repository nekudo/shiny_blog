<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

use Nekudo\ShinyBlog\Domain\ShowArticleDomain;

class ShowArticleAction extends BaseAction
{
    protected $domain;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->domain = new ShowArticleDomain($this->config);
    }

    public function __invoke(array $arguments)
    {
        $slug = $arguments['slug'];
        $article = $this->domain->getArticleBySlug($slug);
    }
}
