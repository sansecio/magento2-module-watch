# Sansec Watcher

## Installation

```bash
composer require sansec/magento2-module-watcher
bin/magento config:set --lock-env system/sansec_watcher/enabled 1
<<<<<<< HEAD
bin/magento config:set --lock-env system/sansec_watcher/endpoint https://[ID].csp.sansec.io/
=======
bin/magento config:set --lock-env system/sansec_watcher/endpoint https://[ID].sansec.watch/
>>>>>>> d12c2f339bbeb6260d4749a553d2d80545cb9aac
bin/magento setup:upgrade
```

## Manual Setup

### Nginx

```
map $msec $set_csp_headers {
    default 0;
    "~[1-5]1$" 1; # 50/10 = ~5%
}

[...]

server {
    [...]
    location [...] {
        if ($set_csp_headers) {
            add_header Reporting-Endpoints 'csp-endpoint="https://[ID].sansec.watch/"';
            add_header Content-Security-Policy-Report-Only "default-src 'self'; script-src 'self' 'unsafe-eval' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; report-to csp-endpoint";
        }
    }
}
```

## License

[MIT License](./LICENSE) - Copyright (c) 2024 Sansec
