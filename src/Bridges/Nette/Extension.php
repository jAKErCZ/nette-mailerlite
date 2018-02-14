<?php declare(strict_types=1);

namespace MailerLite\Bridges\Nette;

use MailerLite\FormContainer;
use MailerLite\MailerLiteForm;
use Nette\DI\CompilerExtension;


/**
 * Class Extension
 *
 * @author  geniv
 * @package MailerLite\Bridges\Nette
 */
class Extension extends CompilerExtension
{
    /** @var array default values */
    private $defaults = [
        'api'           => null,
        'formContainer' => FormContainer::class,
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        // define form container
        $formContainer = $builder->addDefinition($this->prefix('form'))
            ->setFactory($config['formContainer']);

        // define form
        $builder->addDefinition($this->prefix('default'))
            ->setFactory(MailerLiteForm::class, [$config['api'], $formContainer]);
    }
}
