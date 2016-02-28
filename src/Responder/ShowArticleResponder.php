<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

class ShowArticleResponder extends HtmlResponder
{
    /**
     * Renders an article and sends it to client.
     */
    public function __invoke()
    {
        $this->show('article');
    }
}
