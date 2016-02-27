<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

use Nekudo\ShinyBlog\Domain\Entity\ArticleEntity;

class ShowArticleResponder extends HtmlResponder
{
    /**
     * Renders an article and sends it to client.
     *
     * @param ArticleEntity $article
     */
    public function renderArticle(ArticleEntity $article)
    {
        $this->assign('article', $article);
        $this->show('article');
    }
}