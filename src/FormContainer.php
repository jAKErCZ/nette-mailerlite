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
        $translator = $form->getTranslator();
        $form->addText('email', $translator->translate('common.mailerLite.email'))
            ->setRequired($translator->translate('common.mailerLite.emailRequired'))
            ->addRule(Form::EMAIL, $translator->translate('common.mailerLite.emailRule'))
            ->setAttribute('autocomplete', 'off');
        $form->addSubmit('send', $translator->translate('common.mailerLite.send'));
    }
}
