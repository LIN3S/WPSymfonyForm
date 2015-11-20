<?php

/*
 * This file is part of the WPSymfonyForm project.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm;

use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator as BaseTranslator;

/**
 * Class Translator
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class Translator
{
    /**
     * @var Translator|null
     */
    private static $instance = null;

    private static function createTranslator() {
        $translator = new BaseTranslator(ICL_LANGUAGE_CODE);
        /*$translator->addLoader('xlf', new XliffFileLoader());
        $translator->addResource(
            'xlf',
            __DIR__ . '/../../../symfony/validator/Resources/translations/validators.en.xlf',
            'en',
            'validators'
        );
        $translator->addResource(
            'xlf',
            __DIR__ . '/../../../symfony/validator/Resources/translations/validators.es.xlf',
            'es',
            'validators'
        );
        $translator->addResource(
            'xlf',
            __DIR__ . '/../../../symfony/validator/Resources/translations/validators.eu.xlf',
            'eu',
            'validators'
        );*/

        return $translator;
    }

    /**
     * @return \Symfony\Component\Translation\Translator
     */
    public static function getTranslator() {
        if(!self::$instance) {
            self::$instance = self::createTranslator();
        }

        return self::$instance;
    }
}
