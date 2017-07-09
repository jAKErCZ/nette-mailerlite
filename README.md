Mailer lite
===========
Newsletter MailerLite service

www: https://www.mailerlite.com/

API: https://app.mailerlite.com/integrations/api/

Composer API: https://github.com/mailerlite/mailerlite-api-v2-php-sdk

Installation
------------

```sh
$ composer require geniv/nette-mailerlite
```
or
```json
"geniv/nette-mailerlite": ">=1.0.0"
```

require:
```json
"php": ">=5.6.0",
"mailerlite/mailerlite-api-v2-php-sdk": ">=0.2.1"
```

neon configure:
```neon
# mailer lite
mailerLite:
    api: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxy
```

neon configure extension:
```neon
extensions:
    mailerLite: MailerLite\Bridges\Nette\Extension
```

usage:
```php
use MailerLite\MailerLite;

protected function createComponentMailerLite(MailerLite $mailerLite)
{
    return $mailerLite;
}
```

usage:
```latte
{control mailerLite '0000000'}
```
