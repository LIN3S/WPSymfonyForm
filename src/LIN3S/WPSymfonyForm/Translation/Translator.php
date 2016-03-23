<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Translation;

use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator as BaseTranslator;

/**
 * Translator singleton class.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class Translator
{
    /**
     * The instance.
     *
     * @var self
     */
    private static $instance;

    /**
     * The factory method that returns the
     * instance of class in a singleton way.
     *
     * @return static
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = static::create();
        }

        return self::$instance;
    }

    /**
     * Protected facade.
     *
     * @return Translator
     */
    protected static function create()
    {
        $translator = new BaseTranslator(ICL_LANGUAGE_CODE);
        $translator->addLoader('xlf', new XliffFileLoader());

        $languages = ['en', 'es', 'eu'];

        foreach ($languages as $language) {
            $translator->addResource(
                'xlf',
                ABSPATH . '/../vendor/symfony/validator/Resources/translations/validators.' . $language . '.xlf',
                $language,
                'validators'
            );
        }

        return $translator;
    }

    /**
     * This class cannot be instantiated.
     */
    private function __construct()
    {
    }
}
