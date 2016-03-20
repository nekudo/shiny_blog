<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

class ShowFeedResponder extends RssResponder
{
    /**
     * Renders RSS feed and sends it to client.
     */
    public function __invoke()
    {
        $this->show();
    }

    /**
     * Adds articles to xml feed.
     *
     * @param array $articles
     * @return bool
     */
    public function addArticles(array $articles) : bool
    {
        if (empty($articles)) {
            return true;
        }
        foreach ($articles as $article) {
            $title = $article->getTitle();
            $description = $article->getContent();
            $path = $article->getUrl();
            $articleUrl = $this->getUrlFromPath($path);
            $pubDate = date(DATE_RSS, strtotime($article->getDate()));
            $this->addItem($title, $articleUrl, $articleUrl, $description, $pubDate);
        }
        return true;
    }
}
