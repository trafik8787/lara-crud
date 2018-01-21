---
layout: post
title: Navigation
published: true
---

Example of an array of navigation in the file Add service provider App\Providers\LaraCrudProvider::class

## Parameter List

>***tabs***
>
> Inside the `tabs` array, there are tabs
>
> ![Screenshot_tab.png]({{ site.baseurl }}/images/Screenshot_tab.png)

>***tab_name***
>
> Tab name

>***settings***
>
> Tab Settings

>***priory***
>
> Sorting order

>***icon***
>
> Class Icons [http://fontawesome.io/icons/](http://fontawesome.io/icons/)


    Example:
    protected $navigation = [
    
            'App\Http\Node\ExampleNode' => [
                'priory' => 1,
                'title' => 'Example',
                'icon' => 'fa-user-secret'
            ],
    
            'tabs' => [
    
                'tab_name' => [
    
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
    
                'tab_name2' => [
                    ...
                ]
    
            ],
    
            'App\Http\Node\Users' => [
                'priory' => 3,
                'title' => 'Users',
                'icon' => 'fa-tree'
            ],
    
        ];