<?php

declare(strict_types=1);

dataset('link_validation', [
    'A link title is required' => ['title', null, 'required'],
    'A link title is Min 6 ' => ['title', str_repeat('*', 5), 'min'],
    'A link title has max chars 50' => ['title', str_repeat('*', 51), 'max'],

    'A link url is required' => ['url', null, 'required'],
    'A link must be a url' => ['url', 'sometext', 'url'],

    'A link owner_id is required' => ['owner_id', null, 'required'],
    'A link owner must be an integer' => ['owner_id', '23.1', 'integer'],

    'A status is required' => ['status', null, 'required'],
    'A status must be a boolean' => ['status', '23.1', 'boolean'],

    'A position is required' => ['position', '', 'required'],
    'A position must be within a range' => ['position', 'wrong', 'in:LEFT,CENTER,RIGHT'],

    'A sort is required' => ['sort', null, 'required'],
    'A sort is an integer' => ['sort', 'abc', 'integer'],
    'A sort is an integer' => ['sort', '23.1', 'integer'],
]);
