<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

class ShowPageResponder extends HtmlResponder
{
    /**
     * Renders a page and sends it to client.
     */
    public function __invoke()
    {
        $this->show('page');
    }
}
