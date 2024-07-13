<?php

dataset('post_validation', [
    'A post title is required' => ['form.title', null, 'required'],
    'A post title is Min 10 ' => ['form.title', str_repeat('*', 9), 'min'],
    'A post title has max chars 250' => ['form.title', str_repeat('*', 251), 'max'],

    'A post body is required' => ['form.body', null, 'required'],
    'A post body is Min 20 ' => ['form.body', str_repeat('*', 19), 'min'],

    'A post-cover-image is a url' => ['form.cover_image', 'Aviator', 'url'],

    'A post-slug is required' => ['form.slug', null, 'required'],

    'An author_id is required' => ['form.author_id', null, 'required'],
    'An author_id must be an integer' => ['form.author_id', '23.1', 'integer'],

    'An category_id is required' => ['form.category_id', null, 'required'],
    'An category_id must be an integer' => ['form.category_id', 'abc', 'integer'],

    'An channel_id is required' => ['form.channel_id', null, 'required'],
    'An channel_id must be an integer' => ['form.channel_id', 'abc', 'integer'],

    'A post meta_description is required' => ['form.meta_description', null, 'required'],
    'A post meta_description is Min 10 ' => ['form.meta_description', str_repeat('*', 9), 'min'],
    'A post meta_description is Max 500' => ['form.meta_description', str_repeat('*', 501), 'max'],

    'A post is_in_vault flag is required' => ['form.is_in_vault', null, 'required'],
    'A post is_in_vault flag is boolean' => ['form.is_in_vault', 'abc', 'boolean'],

]);
