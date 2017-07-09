<?php

namespace MailerLite;

use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Nette\Application\UI\Control;
use MailerLiteApi\MailerLite;
use Nette\Utils\ArrayHash;


/**
 * Class MailerLiteForm
 *
 * @author  geniv
 * @package MailerLite
 */
class MailerLiteForm extends Control
{
    /** @var MailerLiteForm */
    private $groupsApi, $groupId;
    /** @var string template path */
    private $templatePath;
    /** @var Translator class */
    private $translator;
    /** @var callback method */
    public $onSuccess, $onError;


    /**
     * MailerLiteForm constructor.
     *
     * @param array            $parameters
     * @param ITranslator|null $translator
     */
    public function __construct(array $parameters, ITranslator $translator = null)
    {
        parent::__construct();

        $this->translator = $translator;
        $this->templatePath = __DIR__ . '/MailerLiteForm.latte';    // implicit path

        $this->groupsApi = (new MailerLite($parameters['api']))->groups();
    }


    /**
     * Set template path.
     *
     * @param string $path
     * @return $this
     */
    public function setTemplatePath($path)
    {
        $this->templatePath = $path;
        return $this;
    }


    /**
     * Create component newsletter form with success callback.
     *
     * @param $name
     * @return Form
     */
    protected function createComponentForm($name)
    {
        $form = new Form($this, $name);
        $form->setTranslator($this->translator);
        $form->addText('email', 'Váš E-mail')
            ->setRequired('Pole emailu musí být vyplněno.')
            ->addRule(Form::EMAIL, 'Musí být zadaný validní email.')
            ->setAttribute('autocomplete', 'off');
        $form->addHidden('groupId', $this->groupId);    // prenaseni id skupiny pro mailer lite
        $form->addSubmit('send', 'Odeslat');

        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            $subscriber = [
                'email' => $values['email'],
            ];
            $addedSubscriber = $this->groupsApi->addSubscriber($values['groupId'], $subscriber); // returns added subscriber
            if (!isset($addedSubscriber->error)) {
                $this->onSuccess($values);
            } else {
                $this->onError($addedSubscriber->error);
            }
        };
        return $form;
    }


    /**
     * Render default.
     *
     * @param $groupId
     */
    public function render($groupId)
    {
        $this->groupId = $groupId;

        $template = $this->getTemplate();
        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
