<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

class PageEntity extends BaseEntity
{
    protected $slug;
    protected $date;
    protected $title;
    protected $content;

    public function setMeta(array $metadata)
    {
        foreach($metadata as $metaName => $metaValue) {
            if(!property_exists($this, $metaName)) {
                continue;
            }
            $this->{$metaName} = $metaValue;
        }
    }
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}
