<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Factory;

use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\Validator\ValidatorBuilder;

/**
 * Form factory final class.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class FormFactory
{
    /**
     * Creates a form factory with the default configuration.
     *
     * @return \Symfony\Component\Form\FormFactoryInterface
     */
    public static function get()
    {
        return self::getBuilder()->getFormFactory();
    }

    /**
     * Creates a form factory builder with the default configuration.
     *
     * @return FormFactoryBuilder
     */
    private static function getBuilder()
    {
        $builder = new FormFactoryBuilder();
        $builder->addExtension(new CoreExtension());

        $validatorBuilder = new ValidatorBuilder();
        $builder->addExtension(new ValidatorExtension($validatorBuilder->getValidator()));

        return $builder;
    }
}
