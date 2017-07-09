Mailer lite
===========
Newsletter form MailerLite component

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
use MailerLite\MailerLiteForm;

protected function createComponentMailerLiteForm(MailerLiteForm $mailerLite)
{
    //$mailerLiteForm->setTemplatePath(__DIR__.'/../../vendor/geniv/nette-mailerlite/src/MailerLiteForm.latte');
    $mailerLiteForm->onSuccess[] = function (array $values) {
        $this->flashMessage('Email has been save!', 'success');
        $this->redirect('this');
    };
    $mailerLiteForm->onError[] = function ($error) {
        $this->flashMessage('Error! ' . $error->message, 'danger');
        $this->redirect('this');
    };
    return $mailerLite;
}
```

usage:

_0000000_ is id mailerlite group
```latte
{control mailerLiteForm '0000000'}
```
