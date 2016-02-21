<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

class ShowPageResponder extends HtmlResponder
{
    public function renderPage(array $pageContent)
    {
        $this->assign('meta', $pageContent['meta']);
        $this->assign('content', $pageContent['content']);
        $this->show('page');
    }
}
