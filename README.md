RequestIdBundle
==============

Add in `config/bundles.php`:

```php
<?php
    // ...
    HostMe\RequestIdBundle\RequestIdBundle::class => ['all' => true],
```

Config in `packages/hostme_request_id.yaml`:

```yaml
request_id:
  enable: true # default: true
  enable_monolog: true # default: true
  trust_request_header: true # default: true
  response_header: X-Request-Id
```

Register monolog formatter in `monolog.yaml`:

```php
monolog:
    handlers:
        main:
            ...
            formatter: hostme_request_id.formatter.request_id
```
