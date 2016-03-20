<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

class ShowBlogResponder extends HtmlResponder
{
    /**
     * Renders blog page and sends it to client.
     */
    public function __invoke()
    {
        $this->show('blog');
    }
}
