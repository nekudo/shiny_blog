<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

use Nekudo\ShinyBlog\Domain\ShowBlogDomain;
use Nekudo\ShinyBlog\Exception\NotFoundException;
use Nekudo\ShinyBlog\Responder\ShowBlogResponder;

class ShowBlogAction extends BaseAction
{
    /** @var ShowBlogDomain $domain */
    protected $domain;

    /** @var ShowBlogResponder $responder */
    protected $responder;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->domain = new ShowBlogDomain($this->config);
        $this->responder = new ShowBlogResponder($this->config);
    }

    /**
     * Renders requested article and sends it to client.
     *
     * @param array $arguments
     */
    public function __invoke(array $arguments)
    {
        try {
            $category = (isset($arguments['slug'])) ? $arguments['slug'] : '';
            $page = (isset($arguments['page'])) ? (int)$arguments['page'] : 0;
            $this->responder->setPage($page);
            $this->responder->setTitle($this->domain->getTitle($page, $category));
            $this->responder->setDescription($this->domain->getDescription($page, $category));
            $this->responder->assign('articles', $this->domain->getArticles($page, $category));
            $this->responder->assign('urlNextPage', $this->domain->getUrlNextPage($page, $category));
            $this->responder->assign('urlPrevPage', $this->domain->getUrlPrevPage($page, $category));
            $this->responder->__invoke();
        } catch (NotFoundException $e) {
            $this->responder->notFound($e->getMessage());
        }
    }
}
