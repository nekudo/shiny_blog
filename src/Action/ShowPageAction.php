<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

use Nekudo\ShinyBlog\Domain\ShowPageDomain;
use Nekudo\ShinyBlog\Responder\ShowPageResponder;

class ShowPageAction extends Action
{
    /**
     * @var ShowPageDomain $domain
     */
    protected $domain;

    protected $responder;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->domain = new ShowPageDomain($config);
        $this->responder = new ShowPageResponder($config);
    }

    public function __invoke(array $arguments)
    {
        $pageName = $this->domain->getPageName();
        $pageContent = $this->domain->getPageContent($pageName);
        $this->responder->renderPage($pageContent);
    }
}
