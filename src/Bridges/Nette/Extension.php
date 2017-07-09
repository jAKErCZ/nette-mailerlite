<?php

namespace MailerLite\Bridges\Nette;

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
    /** @var array vychozi hodnoty */
    private $defaults = [
        'api' => null,
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        $builder->addDefinition($this->prefix('default'))
            ->setClass(MailerLiteForm::class, [$config]);
    }
}
