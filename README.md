Bank-ID
============

Bundle for connect [Bank-ID library](https://github.com/dimafe6/bank-id) to your Symfony application.

[![Latest Stable Version](https://poser.pugx.org/dimafe6/bank-id-bundle/v/stable)](https://packagist.org/packages/dimafe6/bank-id-bundle)
[![Latest Unstable Version](https://poser.pugx.org/dimafe6/bank-id-bundle/v/unstable)](https://packagist.org/packages/dimafe6/bank-id-bundle)
[![Total Downloads](https://poser.pugx.org/dimafe6/bank-id-bundle/downloads)](https://packagist.org/packages/dimafe6/bank-id-bundle)
[![License](https://poser.pugx.org/dimafe6/bank-id-bundle/license)](https://packagist.org/packages/dimafe6/bank-id-bundle)

Requirements
============

* PHP 5.6+ or 7.0+
* Symfony 2.7+ or 3+

Installation
============

## Get the bundle using composer

```bash
composer require dimafe6/bank-id-bundle
```

## Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    // ...

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Dimafe6\BankIDBundle\BankIDBundle(),
        );

        // ...
    }
}
```


## Configure the bundle

```yaml
# app/config/config.yml
bank_id:
    wsdl_url: 'https://appapi2.test.bankid.com/rp/v4?wsdl'
    ssl: false
```

###### Full bundle configuration

```yaml
# app/config/config.yml
bank_id:
    wsdl_url: 'https://appapi2.test.bankid.com/rp/v4?wsdl'
    ssl: false
    local_cert: '%kernel.project_dir%/vendor/dimafe6/bank-id/tests/bankId.pem'
    soap_options:
        cache_wsdl: 'memory' #Available values: [none, disk, memory, both]
        soap_version: '1.1' #Available values: [1.1, 1.2]
        compression: true
        trace: true
        connection_timeout: 60 #In seconds
        user_agent: 'User-Agent: <your-user-agent>'
```

## Usage

```php
    // ...
    $orderRef = $container->get('dimafe6.bankid')->getAuthResponse($personalNumber)->orderRef;
    // ...    
    $response = $container->get('dimafe6.bankid')->collectResponse($orderRef);
    // ...
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
