<?php declare(strict_types=1);

namespace MailerLite;

use GeneralForm\IFormContainer;
use Nette\Application\UI\Form;
use Nette\SmartObject;


/**
 * Class FormContainer
 *
 * @author  geniv
 * @package MailerLite
 */
class FormContainer implements IFormContainer
{
    use SmartObject;


    /**
     * Get form.
     *
     * @param Form $form
     */
    public function getForm(Form $form)
    {
        $form->addText('email', 'mailer-lite-form-email')
            ->setRequired('mailer-lite-form-email-required')
            ->addRule(Form::EMAIL, 'mailer-lite-form-email-rule-email')
            ->setAttribute('autocomplete', 'off');
        $form->addSubmit('send', 'mailer-lite-form-send');
    }
}
