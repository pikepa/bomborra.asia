<?php

dataset('post_validation', [
    'A post title is required' => ['title', null, 'required'],
    'A post title is Min 10 ' => ['title', str_repeat('*', 9), 'min'],
    'A post title has max chars 250' => ['title', str_repeat('*', 251), 'max'],

    'A post body is required' => ['body', null, 'required'],
    'A post body is Min 20 ' => ['body', str_repeat('*', 19), 'min'],

    'A post-cover-image is a url' => ['cover_image', 'Aviator', 'url'],

    'A post-slug is required' => ['slug', null, 'required'],

    'An author_id is required' => ['author_id', null, 'required'],
    'An author_id must be an integer' => ['author_id', '23.1', 'integer'],

    'An category_id is required' => ['category_id', null, 'required'],
    'An category_id must be an integer' => ['category_id', 'abc', 'integer'],

    'An channel_id is required' => ['channel_id', null, 'required'],
    'An channel_id must be an integer' => ['channel_id', 'abc', 'integer'],

    'A post meta_description is required' => ['meta_description', null, 'required'],
    'A post meta_description is Min 20 ' => ['meta_description', str_repeat('*', 19), 'min'],
    'A post meta_description is Max 500' => ['meta_description', str_repeat('*', 501), 'max'],

    'A post is_in_vault flag is required' => ['is_in_vault', null, 'required'],
    'A post is_in_vault flag is boolean' => ['is_in_vault', 'abc', 'boolean'],

]);
