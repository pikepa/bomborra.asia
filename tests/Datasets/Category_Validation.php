<?php

declare(strict_types=1);

dataset('category_validation', [
    'A category name is required' => ['name', null, 'required'],
    'A category name is Min 6 ' => ['name', 'uuuuu', 'min'],
    'A category name has max chars 50' => ['name', str_repeat('*', 51), 'max'],

    'A slug is required' => ['slug', null, 'required'],

    'A category description is required' => ['description', null, 'required'],
    'A category description is Min 10 ' => ['description', str_repeat('*', 9), 'min'],
    'A category description is Max 240' => ['description', str_repeat('*', 241), 'max'],

    'Status is required' => ['status', null, 'required'],
    'Status is Boolean' => ['status', 23, 'boolean'],

    'Type is required' => ['type', null, 'required'],
]);
