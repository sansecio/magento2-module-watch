# Sansec Watch

## Installation

```console
composer require sansec/magento2-module-watch
bin/magento setup:upgrade
bin/magento config:set csp/mode/storefront/report_uri https://[ID].sansec.watch/
bin/magento cache:clean config
```

## License

[MIT License](./LICENSE) - Copyright (c) 2024 Sansec
