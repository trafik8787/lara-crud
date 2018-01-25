## Admin Panel LaraCrud

The package is aimed at the fastest deployment and flexible configuration of the admin panel. It has a lot of methods with which you can set it up as you like.

[![License](https://poser.pugx.org/trafik8787/lara-crud/license)](https://packagist.org/packages/trafik8787/lara-crud)
[![Latest Stable Version](https://poser.pugx.org/trafik8787/lara-crud/v/stable)](https://packagist.org/packages/trafik8787/lara-crud)
[![Total Downloads](https://poser.pugx.org/trafik8787/lara-crud/downloads)](https://packagist.org/packages/trafik8787/lara-crud)

### Requirements
    Laravel >=5.4
    PHP >= 7.0.x
    
## Installation




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

[Documentation](https://trafik8787.github.io/lara-crud/documentation/)