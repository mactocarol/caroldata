<?php

return [
    'parent'=> 'parent_id',
    'primary_key' => 'id',
    'generate_url'   => true,
    'childNode' => 'child',
    'body' => [
        'id',
        'category_name',
        'slug',
    ],
    'html' => [
        'label' => 'category_name',
        'href'  => 'slug',
        'url'  => 'url'
    ],
    'dropdown' => [
        'prefix' => '',
        'label' => 'category_name',
        'value' => 'id',
        'style' => 'color:red'
    ]
];
