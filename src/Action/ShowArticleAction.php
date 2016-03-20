<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

use Nekudo\ShinyBlog\Domain\ShowArticleDomain;
use Nekudo\ShinyBlog\Domain\ShowFeedDomain;
use Nekudo\ShinyBlog\Exception\NotFoundException;
use Nekudo\ShinyBlog\Responder\ShowArticleResponder;

class ShowArticleAction extends BaseAction
{
    /** @var ShowArticleDomain $domain */
    protected $domain;

    /** @var ShowFeedDomain $feedDomain */
    protected $feedDomain;

    /** @var ShowArticleResponder $responder */
    protected $responder;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->domain = new ShowArticleDomain($this->config);
        $this->feedDomain = new ShowFeedDomain($this->config);
        $this->responder = new ShowArticleResponder($this->config);
    }

    /**
     * Renders requested article and sends it to client.
     *
     * @param array $arguments
     */
    public function __invoke(array $arguments)
    {
        try {
            $slug = $arguments['slug'];
            $article = $this->domain->getArticleBySlug($slug);
            $this->responder->setTitle($article->getTitle());
            $this->responder->setDescription($article->getDescription());
            $this->responder->setFeedUrl($this->feedDomain->getFeedUrlPath());
            $this->responder->setIndex($this->domain->getIndex());
            $this->responder->assign('article', $article);
            $this->responder->assign('navActive', 'blog');
            $this->responder->__invoke();
        } catch (NotFoundException $e) {
            $this->responder->notFound($e->getMessage());
        }
    }
}
