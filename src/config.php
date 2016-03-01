<?php
declare(strict_types=1);

return [
    // Theme to use:
    'theme' => 'nekudo',

    'themeSettings' => [
        'readMore' => '<a href="%s" class="btn">Read on &raquo;</a>',
    ],

    // SEO settings (title-tags, description, ...)
    'seo' => [
        'home' => [
            'title' => 'nekudo.com - web application development',
            'description' => '',
            'index' => 'index,follow'
        ],
        'blog' => [
            'title' => 'nekudo.com Blog: Project news and web development articles',
            'description' => '',
            'index' => 'index,follow'
        ],
        'blog_paginated' => [
            'title' => 'nekudo.com Blog - Page %d',
            'description' => '',
            'index' => 'noindex,follow'
        ],
        'article' => [
            'title' => '%s | nekudo.com',
            'description' => '',
            'index' => 'index,follow'
        ],
        'page' => [
            'title' => '%s | nekudo.com',
            'description' => '',
            'index' => 'index,follow'
        ],
    ],

    // Articles per page:
    'pagination' => [
        'limit' => 5,
    ],

    // Routes to pages, articles, e.g (Hint: Every page needs its own route!)
    'routes' => [
        'home' => [
            'method' => 'GET',
            'route' => '/',
            'action' => 'page',
        ],
        'imprint' => [
            'method' => 'GET',
            'route' => '/imprint',
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
