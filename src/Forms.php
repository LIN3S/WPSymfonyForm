<?php

namespace LIN3S\WPSymfonyForm;


use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\Validator\ValidatorBuilder;

class Forms {
    /**
     * Creates a form factory with the default configuration.
     *
     * @return \Symfony\Component\Form\FormFactoryInterface The form factory.
     */
    public static function createFormFactory()
    {
        return self::createFormFactoryBuilder()->getFormFactory();
    }

    /**
     * Creates a form factory builder with the default configuration.
     *
     * @return FormFactoryBuilderInterface The form factory builder.
     */
    public static function createFormFactoryBuilder()
    {
        $builder = new FormFactoryBuilder();
        $builder->addExtension(new CoreExtension());

        $validatorBuilder = new ValidatorBuilder();
        $builder->addExtension(new ValidatorExtension($validatorBuilder->getValidator()));

        return $builder;
    }

    /**
     * This class cannot be instantiated.
     */
    private function __construct()
    {
    }
} 