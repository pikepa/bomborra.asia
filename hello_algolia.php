<?php

declare(strict_types=1);

// hello_algolia.php
require __DIR__.'/vendor/autoload.php';

// Connect and authenticate with your Algolia app

// Create a new index and add a record
$index = $client->initIndex('test_index');
$record = ['objectID' => 1, 'name' => 'test_record'];
$index->saveObject($record)->wait();

// Search the index and print the results
$results = $index->search('test_record');
var_dump($results['hits'][0]);
