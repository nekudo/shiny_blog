<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Traits;

trait CategoryFilterTrait
{
    /**
     * Unsets all items from article metadata not matching given category.
     *
     * @param string $categorySlug
     */
    protected function filterArticlesByCategorySlug(string $categorySlug)
    {
        foreach ($this->articleMeta as $i => $metadata) {
            if (empty($metadata['categories'])) {
                unset($this->articleMeta[$i]);
                continue;
            }
            $categorySlugs = $this->getCategorySlugs($metadata['categories']);
            if (!in_array($categorySlug, $categorySlugs)) {
                unset($this->articleMeta[$i]);
                continue;
            }
        }
    }

    /**
     * Returns list of category slugs from given category names.
     *
     * @param string $categories
     * @return array
     */
    protected function getCategorySlugs(string $categories) : array
    {
        $categories = trim($categories);
        if (empty($categories)) {
            return [];
        }
        $categoryNames = explode(',', $categories);
        $categorySlugs = [];
        foreach ($categoryNames as $categoryName) {
            $categorySlug = $this->makeSlug($categoryName);
            array_push($categorySlugs, $categorySlug);
        }
        return $categorySlugs;
    }
}
