<?php

use Controllers\Landing\LandingController;

return [
    [
        'method' => 'GET',
        'pattern' => '/menu/',
        'handle' => fn() => [new LandingController(), 'menu', []],
    ],
    [
        'method' => 'GET',
        'pattern' => '/how-to-enter/',
        'handle' => fn() => [new LandingController(), 'howToEnter', []],
    ],
    [
        'method' => 'GET',
        'pattern' => '/prizes/',
        'handle' => fn() => [new LandingController(), 'prizes', []],
    ],
];
