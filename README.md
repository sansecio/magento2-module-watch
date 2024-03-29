# CSP Monitor

## Installation

```bash
composer require sansec/magento2-module-cspmon
bin/magento config:set --lock-env system/cspmon/enabled 1
bin/magento config:set --lock-env system/cspmon/endpoint https://[ID].csp.sansec.io/
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
            add_header Reporting-Endpoints 'csp-endpoint="https://[ID].csp.sansec.io/"';
            add_header Content-Security-Policy-Report-Only "default-src 'self'; script-src 'self' 'unsafe-eval' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; report-to csp-endpoint";
        }
    }
}
```
