---
layout: post
title: Configuration
published: true
---

File config/lara-config.php

## Parameter List

>***admin_panel_name***
>
> Name Logo and url

    return [
        'admin_panel_name' => ['LaraAdmin', '/admin'],
        'middleware' => ['web'],
        'url_group' => 'admin',
        'field_disable' => [
            'created_at',
            'updated_at'
        ]
    ];