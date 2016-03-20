<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

class NotFoundResponder extends HtmlResponder
{
    /**
     * Renders the 404 page and sends it to client.
     */
    public function __invoke()
    {
        $this->assign('navActive', '');
        $templateContent = $this->renderTemplate('not_found');
        $this->templateData['template'] = $templateContent;
        $html = $this->renderLayout();
        $this->notFound($html);
    }
}
