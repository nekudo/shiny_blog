<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Traits;

trait SlugableTrait
{
    /**
     * Generates slug from input string.
     *
     * @param string $str
     * @return string
     */
    protected function makeSlug(string $str) : string
    {
        $chars = ['ä', 'ö', 'ü', 'ß', ' '];
        $replacements = ['ae', 'oe', 'ue', 'ss', '-'];
        $str = strtolower(trim($str));
        $str = str_replace($chars, $replacements, $str);
        $str = preg_replace('/[^a-z0-9-]/', '', $str);
        return $str;
    }
}