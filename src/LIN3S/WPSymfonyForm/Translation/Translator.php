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

use Symfony\Component\Finder\Finder;
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
        $locale = 'es_ES';
        if (defined('ICL_LANGUAGE_CODE')) {
            $locale = ICL_LANGUAGE_CODE;
        }

        $translator = new BaseTranslator($locale);
        $translator->addLoader('xlf', new XliffFileLoader());

        $finder = new Finder();
        $finder->files()->in(ABSPATH . '/../vendor/symfony/validator/Resources/translations/');
        foreach ($finder as $validator) {
            $locale = str_replace('validators.', '', $validator->getRelativePathName());
            $locale = str_replace('.xlf', '', $locale);

            $translator->addResource(
                'xlf',
                $validator->getRealpath(),
                $locale,
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
