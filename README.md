# Kheyfets ErpOrderSync
The module allows to synchronize orders in external ERP.

## Instalation
Please use composer to install this module.

1. Add new VCS in your magento composer.json file:

``` 
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/heyfets/erp-order-sync.git"
    },
],
```
2. Require extention:
```
composer require kheyfets/module-erp-order-sync:dev-master
```
3. Run Magento setup command:
```
bin/magento se:up`
```
