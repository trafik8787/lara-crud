<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 10.08.2017
 * Time: 23:03
 */

return [
    'admin_panel_name' => ['LaraAdmin', '/admin'],
    'middleware' => ['web'],
    'url_group' => 'admin',
    'field_disable' => [
        'created_at',
        'updated_at'
    ],
    'namespace' => 'Trafik8787\LaraCrud\Controllers'
];