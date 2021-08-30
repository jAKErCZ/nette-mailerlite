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
"mailerlite/mailerlite-api-v2-php-sdk": ">=0.2.1",
"geniv/nette-general-form": ">=1.0.0"
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
use GeneralForm\IFormContainer;
use MailerLite\MailerLiteForm;

#[\Nette\DI\Attributes\Inject]
public IFormContainer $formContainer;

protected function createComponentMailerLiteForm(): MailerLiteForm
{
  $mailerLiteForm = new MailerLiteForm('SET API KEY', $this->formContainer, $this->translator);
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
```

usage API out of form:

```php
use GeneralForm\IFormContainer;
use MailerLite\MailerLiteForm;

#[\Nette\DI\Attributes\Inject]
public IFormContainer $formContainer;


 public function succeededForm(Form $form, ArrayHash $values)
 {
     $mailerLiteForm = new MailerLiteForm('SET API KEY', $this->formContainer, $this->translator);
     
     if ($values->newsletter == 1){
         $subscriber = [
           'email' => $values->email,
         ];
         $mailerLiteForm->getGroupApi()->addSubscriber('SET GROUP ID', $subscriber);
     }
 }
```
