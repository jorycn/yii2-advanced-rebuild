<?php
return [
    'adminEmail' => 'admin@example.com',
    'baseSideMenu' => [
        'dashboard' => [
            'visible' => 1,
            'label' => 'Dashboard',
            'img' => 'dashboard',
            'url' => '',
            'options' => [],
            'items' => [],
        ],
        'content' => [
            'visible' => 1,
            'label' => 'Content',
            'img' => 'book',
            'url' => '#',
            'options' => [],
            'items' => [
                'posts' => [
                    'visible' => 1,
                    'label' => 'Posts',
                    'img' => 'file-text',
                    'url' => '/posts',
                    'options' => ['class' => 'data-posts'],
                    'items' => []
                ],
                'category' => [
                    'visible' => 1,
                    'label' => 'Category',
                    'img' => 'files-o',
                    'url' => "/category",
                    'options' => ['class' => 'data-category'],
                    'items' => []
                ],
                /*
                'menu' => [
                    'visible' => 1,
                    'label' => 'Menu',
                    'img' => 'list',
                    'url' => "#",
                    'options' => [],
                    'items' => []
                ],
                'posts' => [
                    'visible' => 1,
                    'label' => 'Posts',
                    'img' => 'tasks',
                    'url' => '/records',
                    'options' => [],
                    'items' => []
                ],
                'comments' => [
                    'visible' => 1,
                    'label' => 'Comments',
                    'img' => 'comments',
                    'url' => '/comments',
                    'options' => [],
                    'items' => []
                ],
                'blogs' => [
                    'visible' => 1,
                    'label' => 'Blogs',
                    'img' => 'pagelines',
                    'url' => '/blog',
                    'options' => [],
                    'items' => []
                ],*/
            ],
        ],
        'users' => [
            'visible' => 1,
            'label' => 'Users',
            'img' => 'users',
            'url' => "/users",
            'options' => [],
            'items' => [],
        ],
        'setting' => [
            'visible' => 1,
            'label' => 'Settings',
            'img' => 'wrench',
            'url' => '#',
            'options' => [],
            'items' => [
                'translate' => [
                    'visible' => 1,
                    'label' => 'Translate',
                    'img' => 'book',
                    'url' => "/translate",
                    'options' => ['class' => 'data-translate'],
                    'items' => []
                ],
                'roles' => [
                    'visible' => 1,
                    'label' => 'Roles',
                    'img' => 'user',
                    'url' => "/roles",
                    'options' => ['class' => 'data-roles'],
                    'items' => []
                ],
                'permissions' => [
                    'visible' => 1,
                    'label' => 'Permissions',
                    'img' => 'lock',
                    'url' => "/permissions",
                    'options' => ['class' => 'data-permissions'],
                    'items' => []
                ]
            ],
        ],
    ],
];
