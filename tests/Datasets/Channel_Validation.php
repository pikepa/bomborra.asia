<?php

declare(strict_types=1);

dataset('channel_validation', [
    'A channel name is required' => ['name', null, 'required'],
    'A channel name is Min 6 ' => ['name', str_repeat('*', 5), 'min'],
    'A channel name has max chars 50' => ['name', str_repeat('*', 51), 'max'],

    'A channel-slug is required' => ['slug', null, 'required'],

    'A status is required' => ['status', null, 'required'],
    'A status must be a boolean' => ['status', '23.1', 'boolean'],

    'A sort is required' => ['sort', null, 'required'],
    'A sort is an integer' => ['sort', 'abc', 'integer'],
    'A sort is an integer' => ['sort', '23.1', 'integer'],
]);
