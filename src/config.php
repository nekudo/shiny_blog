<?php
declare(strict_types=1);

return [
    'theme' => 'nekudo',

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
        'article' => [
            'method' => 'GET',
            'route' => '/blog/{alias:[a-z0-9-]+}',
            'action' => 'article',
        ],
    ],

    'themesFolder' => __DIR__ . '/../themes/',
    'contentsFolder' => __DIR__ . '/../contents/',
];
