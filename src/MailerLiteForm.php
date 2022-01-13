<?php declare(strict_types=1);

namespace MailerLite;

use GeneralForm\ITemplatePath;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;
use MailerLiteApi\MailerLite;
use Nette\Localization\Translator;

/**
 * Class MailerLiteForm
 *
 * @author  geniv, jakerzc
 * @package MailerLite
 */
class MailerLiteForm extends Control implements ITemplatePath
{
    /** @var MailerLite */
    private $groupsApi, $groupId, $isAjax;
    /** @var string */
    private $templatePath;
    /** @var Translator */
    private $translator;
    /** @var callback method */
    public $onSuccess, $onError;

    /**
     * MailerLiteForm constructor.
     *
     * @param string $api
     * @param Translator $translator
     * @throws \MailerLiteApi\Exceptions\MailerLiteSdkException
     */
    public function __construct(string $api, Translator $translator = null, $isAjax = false)
    {
        $this->groupsApi = (new MailerLite($api))->groups();    // init MailerLite api
        $this->isAjax = $isAjax;
        $this->translator = $translator;
        $this->templatePath = __DIR__ . '/MailerLiteForm.latte';    // set path
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }

    /**
     * Set groupID
     *
     * @param string $groupId
     */
    public function setGroupID(string $groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * Return GroupApi
     *
     */
    public function getGroupApi()
    {
        return $this->groupsApi;
    }

    /**
     * Create component form.
     *
     * @return Form
     */
    protected function createComponentForm(): Form
    {
        $form = new Form;
        if ($this->translator == true){
            $form->setTranslator($this->translator);
        }
        if ($this->isAjax == true){
            $form->getElementPrototype()->class('ajax');
        }
        $form->addHidden('groupId', $this->groupId);    // prenaseni id skupiny pro mailer lite
        $form->addText('email', $this->translator ? $this->translator->translate('common.mailerLite.email') : 'Email')
            ->setRequired($this->translator ? $this->translator->translate('common.mailerLite.emailRequired') : 'Email is required.')
            ->addRule(Form::EMAIL, $this->translator ? $this->translator->translate('common.mailerLite.emailRule') : 'Email is not valid.')
            ->setAttribute('autocomplete', 'off');
        $form->addSubmit('send', $this->translator ? $this->translator->translate('common.mailerLite.send') : 'Subscribe');

        $form->onSuccess[] = function (Form $form, array $values) {
            $subscriber = [
                'email' => $values['email'],
            ];
            $addedSubscriber = $this->groupsApi->addSubscriber($values['groupId'], $subscriber); // returns added subscriber

            if ($this->presenter->isAjax()) {
                $this->redrawControl('wrapper');
                $form->reset();
            }

            if (!isset($addedSubscriber->error)) {
                $this->onSuccess($values);
            } else {
                $this->onError($addedSubscriber->error);
            }
        };
        return $form;
    }

    /**
     * Render.
     */
    public function render()
    {
        $template = $this->getTemplate();
        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}