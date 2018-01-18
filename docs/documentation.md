---
layout: page
title: Documentation
permalink: /documentation/
---
***

- [Field Settings](/Field-Settings)
- [Relations](/Relations)
- [Validation](/Validation)
- [Callback](/Callback)
- [Navigation](/Navigation)
- [Configuration](/Configuration)


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