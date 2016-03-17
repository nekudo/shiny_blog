<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

class PageEntity extends BaseEntity
{
    /**
     * Sets the entity key.
     */
    protected function setKey()
    {
        $this->key = 'page';
    }
}
