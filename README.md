# CSP Monitor

## Installation

```bash
composer require sansec/magento2-module-cspmon
bin/magento config:set --lock-env cspmon/settings/endpoint https://csp.sansec.io/[ID]
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
            add_header Reporting-Endpoints 'csp-endpoint="https://csp.sansec.io/373b60f0-19a9-476d-8a0e-38fc5433413a"';
            add_header Content-Security-Policy-Report-Only "default-src 'self'; script-src 'self' 'unsafe-eval' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; report-to csp-endpoint";
        }
    }
}
```
