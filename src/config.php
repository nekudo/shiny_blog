<?php
declare(strict_types=1);

return [
    'routes' => [
        'home' => [
            'method' => 'GET',
            'route' => '/',
            'action' => 'home'
        ],
        'article' => [
            'method' => 'GET',
            'route' => '/blog/{alias:[a-z0-9-]+}',
            'action' => 'article'
        ],
    ]
];
