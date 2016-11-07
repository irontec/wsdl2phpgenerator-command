# Wsdl2PhpGeneratorCommandBundle

Provides []wsdl2phpgenerator/wsdl2phpgenerator](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator) as a command on your Symfony Project.

## Installation

Require the `internet/wsdl2phpgenerator-command` package in your composer.json and update your dependencies.

    $ composer require internet/wsdl2phpgenerator-command

Add the Wsdl2PhpGeneratorCommandBundle to your application's kernel:

```php
    public function registerBundles()
    {
        // ...
    
    
        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            // ...
            
            $bundles[] = new Internet\Wsdl2PhpGeneratorCommandBundle(),
        );
        // ...
    }
````
*You probabibly only need this bundle during development, so...*


## Usage

There will be a new command available: 

    $ php bin/console wsdl2phpgenerator:parser
    

## License

See LICENSE.