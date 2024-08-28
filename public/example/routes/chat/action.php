<?php

use Controllers\Chat\ActionController;

return [
    [
        'method' => 'GET',
        'pattern' => '/action/get-id/',
        'handle' => fn() => [new ActionController(), 'getId', []],
    ]
];
