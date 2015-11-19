<?php

namespace LIN3S\WPSymfonyForm;

use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator as BaseTranslator;

class Translator
{
    private static $instance = null;

    private static function createTranslator() {
        $translator = new BaseTranslator(ICL_LANGUAGE_CODE);
        $translator->addLoader('xlf', new XliffFileLoader());
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
        );

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
