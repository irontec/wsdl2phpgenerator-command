# Wsdl2PhpGeneratorCommandBundle

Provides [wsdl2phpgenerator/wsdl2phpgenerator (3.4)](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator) as a command on your Symfony Project ("~2.6|~3.0").

## Installation

Require the `irontec/wsdl2phpgenerator-command-bundle` package in your composer.json and update your dependencies.

    $ composer require irontec/wsdl2phpgenerator-command-bundle


Add the Wsdl2PhpGeneratorCommandBundle to your application's kernel:

```php
    public function registerBundles()
    {
        // ...
    
    
        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            // ...
            
            $bundles[] = new Irontec\Wsdl2PhpGeneratorCommandBundle\Wsdl2PhpGeneratorCommandBundle(),
        );
        // ...
    }
````
*You probabibly only need this bundle during development, so...*


## Usage

There will be a new command available: 


    $php bin/console list
    
    // ...
    wsdl2phpgenerator
     wsdl2phpgenerator:generate              Provides wsdl2phpgenerator/wsdl2phpgenerator as a command on your Symfony Project.



Command usage options:

    $ php bin/console wsdl2phpgenerator:generate --help
    Options:
      -i, --input=INPUT                     Input WSDL URL [Required*]
      -o, --output=OUTPUT                   Output Directory for self generated classes [Required*]
          --namespace[=NAMESPACE]           Class Namespace "Class\Example"
      -p, --proxy[=PROXY]                   URL-like format proxy settings
          --shared-types                    sharedTypes option set to true
          --constructorParamsDefaultToNull  constructorParamsDefaultToNull value set to true

