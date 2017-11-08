<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 10.08.2017
 * Time: 23:03
 */

return [
    'middleware' => ['web'],
    'url_group' => 'admin',
    'field_disable' => [
        'created_at',
        'updated_at'
    ]
];