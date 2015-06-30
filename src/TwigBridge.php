<?php

namespace LIN3S\WPSymfonyForm;

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;

class TwigBridge
{
    public static function addExtension($twig, $formTheme = 'form_div_layout.html.twig')
    {
        $formEngine = new TwigRendererEngine(array($formTheme));
        $twig->addExtension(
            new FormExtension(new TwigRenderer($formEngine))
        );

        $translator = new Translator(ICL_LANGUAGE_CODE);
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

        $twig->addExtension(
            new TranslationExtension($translator)
        );

        return $twig;
    }
} 