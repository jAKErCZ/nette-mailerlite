MailerLite
==========

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
"php": ">=7.0.0",
"mailerlite/mailerlite-api-v2-php-sdk": ">=0.2.1",
"geniv/nette-general-form": ">=1.0.0"
```

neon configure:
```neon
# mailer lite
mailerLite:
#   autowired: true
    api: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxy
#   formContainer: MailerLite\FormContainer
```

neon configure extension:
```neon
extensions:
    mailerLite: MailerLite\Bridges\Nette\Extension
```

usage:
```php
protected function createComponentMailerLiteForm(MailerLiteForm $mailerLiteForm)
{
    //$mailerLiteForm->setTemplatePath(__DIR__ . '/templates/MailerLiteForm.latte');
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
