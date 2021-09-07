MailerLite
==========

www: https://www.mailerlite.com/

API: https://app.mailerlite.com/integrations/api/

Composer API: https://github.com/mailerlite/mailerlite-api-v2-php-sdk

Installation
------------

```sh
$ composer require jakercz/nette-mailerlite
```

or

```json
"jakercz/nette-mailerlite": "^2.0"
```

require:

```json
"php": ">=7.0.0",
"mailerlite/mailerlite-api-v2-php-sdk": ">=0.2.1"
```

neon configure extension:

```neon
extensions:
    mailerLite: MailerLite\Bridges\Nette\Extension
```
translate:

file: common.cs_CZ.neon
```json
mailerLite:
    email: "E-mail"
    emailRequired: "E-mail je povinný."
    emailRule: "E-mail není validní."
    send: "Odebírat"
```

usage:

```php
use MailerLite\MailerLiteForm;

protected function createComponentMailerLiteForm(): MailerLiteForm
{
  $mailerLiteForm = new MailerLiteForm('SET API KEY', $this->translator);
  $mailerLiteForm->setGroupID('SET GROUP ID');
  //$mailerLiteForm->setTemplatePath(__DIR__ . '/MailerLiteForm.latte');
  $mailerLiteForm->onSuccess[] = function (array $values) {
       $this->flashMessage('Email has been save!', 'success');
       $this->redirect('this');
  };
  $mailerLiteForm->onError[] = function ($error) {
       $this->flashMessage('Error! ' . $error->message, 'danger');
       $this->redirect('this');
  };
  return $mailerLiteForm;
}
```
usage:
```latte
{control mailerLiteForm}

{block scripts}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/nette.ajax.js@2.3.0/nette.ajax.js"></script>
    <script type="text/javascript" src="https://nette.github.io/resources/js/3/netteForms.min.js"></script>
    <script>
        $(function () {
            $.nette.init();
        });
    </script>
{/block}
```

usage API out of form:

```php
use MailerLite\MailerLiteForm;


 public function succeededForm(Form $form, ArrayHash $values)
 {
     $mailerLiteForm = new MailerLiteForm('SET API KEY', $this->translator);
     
     if ($values->newsletter == 1){
         $subscriber = [
           'email' => $values->email,
         ];
         $mailerLiteForm->getGroupApi()->addSubscriber('SET GROUP ID', $subscriber);
     }
 }
```
