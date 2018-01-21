---
layout: page
title: Documentation
permalink: /documentation/
---
***

- [Field Settings]({{ site.baseurl }}/Field-Settings)
- [Node Class]({{ site.baseurl }}/Node-Class)
- [Relations]({{ site.baseurl }}/Relations)
- [Validation]({{ site.baseurl }}/Validation)
- [Callback]({{ site.baseurl }}/Callback)
- [Navigation]({{ site.baseurl }}/Navigation)
- [Configuration]({{ site.baseurl }}/Configuration)


## Introduction
***
The package includes many methods that will allow you to adapt the admin panel to your needs.

## Installation!
***
A place to include any other types of information that you'd like to include about yourself.

1. To get the latest version, simply require the project using [Composer](https://getcomposer.org):
 
    ```
    $ composer require trafik8787/lara-crud 

    ```
    
2. Run the installation and wait for it to finish.
     
    ```
    artisan lara:example
    ```
    
3. Add service provider ***App\Providers\LaraCrudProvider::class*** to /config/app.php file.

    ```
    'providers' => [
        ...
    
         App\Providers\LaraCrudProvider::class,
    ],
    
    ```

4. Finish you can go to the link ***http://you_domain/admin***


## Create new Pages

    Example:
    artisan lara:node ExampleNode
 
&nbsp;   
The command creates two classes in the class `ExampleNode` and `ExampleNodeModel`. Add them to the array in the provider `App\Providers\LaraCrudProvider`:

    Example:
    protected $nodes = [
            ...
    
            'App\Http\Node\Model\ExampleNodeModel' => 'App\Http\Node\ExampleNode',
    ];
    

You can go to http://you_domain/admin/example_node_model        
    
**Next documentation** [Navigation](/Navigation)
    
