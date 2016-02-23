<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

use Nekudo\ShinyBlog\Domain\Entity\PageEntity;

class ShowPageResponder extends HtmlResponder
{
    /**
     * Renders a page and sends it to client.
     *
     * @param PageEntity $page
     */
    public function renderPage(PageEntity $page)
    {
        $this->assign('page', $page);
        $this->show('page');
    }
}
