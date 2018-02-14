<?php declare(strict_types=1);

namespace MailerLite;

use GeneralForm\IFormContainer;
use GeneralForm\ITemplatePath;
use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Nette\Application\UI\Control;
use MailerLiteApi\MailerLite;


/**
 * Class MailerLiteForm
 *
 * @author  geniv
 * @package MailerLite
 */
class MailerLiteForm extends Control implements ITemplatePath
{
    /** @var MailerLite */
    private $groupsApi, $groupId;
    /** @var string */
    private $templatePath;
    /** @var IFormContainer */
    private $formContainer;
    /** @var ITranslator */
    private $translator;
    /** @var callback method */
    public $onSuccess, $onError;


    /**
     * MailerLiteForm constructor.
     *
     * @param string           $api
     * @param IFormContainer   $formContainer
     * @param ITranslator|null $translator
     * @throws \MailerLiteApi\Exceptions\MailerLiteSdkException
     */
    public function __construct(string $api, IFormContainer $formContainer, ITranslator $translator = null)
    {
        parent::__construct();

        $this->groupsApi = (new MailerLite($api))->groups();    // init MailerLite api
        $this->formContainer = $formContainer;
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
     * Create component form.
     *
     * @param $name
     * @return Form
     */
    protected function createComponentForm(string $name): Form
    {
        $form = new Form($this, $name);
        $form->setTranslator($this->translator);
        $form->addHidden('groupId', $this->groupId);    // prenaseni id skupiny pro mailer lite
        $this->formContainer->getForm($form);

        $form->onSuccess[] = function (Form $form, array $values) {
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
     * Render.
     *
     * @param string $groupId
     */
    public function render(string $groupId)
    {
        $template = $this->getTemplate();

        $this->groupId = $groupId;

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
