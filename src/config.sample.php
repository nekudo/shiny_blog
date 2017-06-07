<?php
declare(strict_types=1);

return [

    // Defined the theme you want to use:
    'theme' => 'kiss',

    'themeSettings' => [

        // Html Markup for read-more button:
        'readMore' => '<a href="%s" class="btn">Read on &raquo;</a>',
    ],

    /* SEO related settings.
     * In this section you can define title-tags, meta-description and "index/follow" settings for
     * each page-type.
     */
    'seo' => [
        'blog' => [
            'title' => 'ShinyBlog - A shiny blog',
            'description' => 'Enter meta-description for blog pages.',
            'index' => 'index,follow'
        ],
        'blog_paginated' => [
            'title' => 'Meta title for paginated blog pages - Page %d',
            'description' => 'Enter meta-description for all pages greater than page 1.',
            'index' => 'noindex,follow'
        ],
        'category' => [
            'title' => 'Enter Blog Category Title',
            'description' => 'Enter meta-description for blog-categories...',
            'index' => 'noindex,follow'
        ],
        'category_paginated' => [
            'title' => 'Enter Blog Category Title - Page %d',
            'description' => 'Enter meta-description for paginated blog-categories...',
            'index' => 'noindex,follow'
        ],
        'article' => [
            'title' => '%s',
            'description' => '%s',
            'index' => 'index,follow'
        ],
        'page' => [
            'title' => '%s',
            'description' => '%s',
            'index' => 'index,follow'
        ],
    ],

    'pagination' => [

        // Defines how blog articles are shown per page:
        'limit' => 8,
    ],

    'feed' => [

        // Defines how many articles will show up in RSS feed:
        'limit' => 20,
    ],

    // Defines sitemap priority and changefreq settings for different page types:
    'sitemap' => [
        'blog' => [
            'changefreq' => 'daily',
            'priority' => '1.0',
        ],
        'article' => [
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ],
        'page' => [
            'changefreq' => 'monthly',
            'priority' => '0.4',
        ],
    ],

    /* Routing
     *
     * In this section you can define the URLs for every page-type.
     * Please note that every page needs its own route.
     * Possible actions are: blog, article, page, feed
     */
    'routes' => [
        'home' => [
            'method' => 'GET',
            'route' => '/',
            'buildPattern' => '/',
            'action' => 'page',
        ],
        'sitemap' => [
            'method' => 'GET',
            'route' => '/sitemap.xml',
            'action' => 'sitemap',
        ],
        'imprint' => [
            'method' => 'GET',
            'route' => '/imprint',
            'buildPattern' => '/imprint',
            'action' => 'page',
        ],
        'blog' => [
            'method' => 'GET',
            'route' => '/blog',
            'buildPattern' => '/blog',
            'action' => 'blog',
        ],
        'blog_paginated' => [
            'method' => 'GET',
            'route' => '/blog/page-{page:[0-9]+}',
            'buildPattern' => '/blog/page-%d',
            'action' => 'blog',
        ],
        'category' => [
            'method' => 'GET',
            'route' => '/blog/category/{slug:[a-z0-9-]+}',
            'buildPattern' => '/blog/category/%s',
            'action' => 'blog',
        ],
        'category_paginated' => [
            'method' => 'GET',
            'route' => '/blog/category/{slug:[a-z0-9-]+}/page-{page:[0-9]+}',
            'buildPattern' => '/blog/category/%s/page-%d',
            'action' => 'blog',
        ],
        'feed' => [
            'method' => 'GET',
            'route' => '/blog/feed',
            'buildPattern' => '/blog/feed',
            'action' => 'feed',
        ],
        'category_feed' => [
            'method' => 'GET',
            'route' => '/blog/feed/{slug:[a-z0-9-]+}',
            'buildPattern' => '/blog/feed/%s',
            'action' => 'feed',
        ],
        'article' => [
            'method' => 'GET',
            'route' => '/blog/{slug:[a-z0-9-]+}',
            'buildPattern' => '/blog/%s',
            'action' => 'article',
        ],
    ],

    // Path to themes folder:
    'themesFolder' => __DIR__ . '/../themes/',

    // Path to folder containing article/page contents:
    'contentsFolder' => __DIR__ . '/../contents/',
];
