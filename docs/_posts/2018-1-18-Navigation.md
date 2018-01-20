---
layout: post
title: Navigation
published: true
---


    protected $navigation = [
    
            'App\Http\Node\ExampleNode' => [
                'priory' => 1,
                'title' => 'Example',
                'icon' => 'fa-user-secret'
            ],
    
            'tabs' => [
    
                'Tab1' => [
    
                    'settings' => [
                       'icon' => 'fa-user-secret',
                        'priory' => 2,
                    ],
    
                    'node' => [
    
                        'App\Http\Node\Articles' => [
                            'priory' => 2,
                            'title' => 'Articles',
                            'icon' => 'fa-tree'
                        ]
                    ]
                ],
    
            ],
    
            'App\Http\Node\Users' => [
                'priory' => 3,
                'title' => 'Users',
                'icon' => 'fa-tree'
            ],
    
        ];