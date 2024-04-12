# Sansec Watch

## Installation

```console
composer require sansec/magento2-module-watch
bin/magento setup:upgrade
bin/magento config:set --lock-env system/sansec_watch/enabled 1
bin/magento config:set --lock-env system/sansec_watch/endpoint https://[ID].sansec.watch/
bin/magento cache:clean config
```

## Manual Setup

### Nginx

```nginx
map $msec $set_watch_headers {
    default 0;
    "~[1-5]1$" 1; # ~5%
}

server {
    location [...] {
        if ($set_watch_headers) {
            add_header Reporting-Endpoints 'csp-endpoint="https://[ID].sansec.watch/"';
            add_header Content-Security-Policy-Report-Only "default-src 'self'; script-src 'self' 'unsafe-eval' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; report-to csp-endpoint";
        }
    }
}
```

## License

[MIT License](./LICENSE) - Copyright (c) 2024 Sansec
