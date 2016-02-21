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

    /**
     * @var ShowPageResponder $responder
     */
    protected $responder;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->domain = new ShowPageDomain($config);
        $this->responder = new ShowPageResponder($config);
    }

    /**
     * Renders requested page and sends it to client.
     *
     * @param array $arguments
     */
    public function __invoke(array $arguments)
    {
        $pageName = $this->domain->getPageName();
        $pageContent = $this->domain->getPageContent($pageName);
        $this->responder->renderPage($pageContent);
    }
}
