<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

use SimpleXMLElement;

class RssResponder extends HttpResponder
{
    /** @var string $channelTitle */
    protected $channelTitle = '';

    /** @var string $channelLink */
    protected $channelLink = '';

    /** @var string $channelDescription */
    protected $channelDescription = '';

    /** @var string $channelPubDate */
    protected $channelPubDate = '';

    /** @var array $items */
    protected $items = [];

    /**
     * Sets channel-title property.
     *
     * @param string $channelTitle
     */
    public function setChannelTitle(string $channelTitle)
    {
        $this->channelTitle = $channelTitle;
    }

    /**
     * Sets channel-link property.
     *
     * @param string $channelLink
     */
    public function setChannelLink(string $channelLink)
    {
        $this->channelLink = $this->getUrlFromPath($channelLink);
    }

    /**
     * Sets channel description property.
     *
     * @param string $channelDescription
     */
    public function setChannelDescription(string $channelDescription)
    {
        $this->channelDescription = $channelDescription;
    }

    /**
     * Sets channel pubDate property.
     *
     * @param string $pubDate
     */
    public function setChannelPubDate(string $pubDate)
    {
        $this->channelPubDate = $pubDate;
    }

    /**
     * Adds item/item-data to feed.
     *
     * @param string $title
     * @param string $link
     * @param string $guid
     * @param string $description
     * @param string $pubDate
     */
    public function addItem(
        string $title,
        string $link,
        string $guid,
        string $description,
        string $pubDate
    ) {
        array_push($this->items, [
            'title' => $title,
            'link' => $link,
            'guid' => $guid,
            'description' => $description,
            'pubDate' => $pubDate
        ]);
    }

    /**
     * Renders feed and sends result to client.
     */
    public function show()
    {
        $feedData = $this->renderFeed();
        $this->setHeader();
        $this->found($feedData);
    }

    /**
     * Renders the XML feed.
     *
     * @return string
     */
    public function renderFeed() : string
    {
        $xml = new SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0" />',
            LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL
        );

        // add cannel:
        $xml->addChild('channel');
        $xml->channel->addChild('title', $this->channelTitle);
        $xml->channel->addChild('link', $this->channelLink);
        $xml->channel->addChild('description', $this->channelDescription);
        $xml->channel->addChild('pubDate', $this->channelPubDate);

        // add items:
        foreach ($this->items as $itemData) {
            $item = $xml->channel->addChild('item');
            $item->addChild('title', $itemData['title']);
            $item->addChild('link', $itemData['link']);
            $item->addChild('guid', $itemData['guid']);
            $item->addChild('pubDate', $itemData['pubDate']);
            $item->description = "<![CDATA[" . $itemData['description'] . "]]>";
        }

        // return xml:
        return $xml->asXML();
    }

    /**
     * Sets XML header.
     */
    protected function setHeader()
    {
        header('Content-Type: text/xml', true);
    }
}
