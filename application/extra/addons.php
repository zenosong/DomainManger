<?php

return [
    'autoload' => false,
    'hooks' => [
        'testhook' => [
            'domain',
        ],
        'user_sidenav_after' => [
            'domain',
            'invite',
            'recharge',
        ],
        'user_register_successed' => [
            'invite',
        ],
    ],
    'route' => [
        '/example$' => 'example/index/index',
        '/example/d/[:name]' => 'example/demo/index',
        '/example/d1/[:name]' => 'example/demo/demo1',
        '/example/d2/[:name]' => 'example/demo/demo2',
        '/invite/[:id]$' => 'invite/index/index',
    ],
    'priority' => [],
    'domain' => '',
];
