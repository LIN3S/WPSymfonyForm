<?php

namespace LIN3S\WPSymfonyForm\Twig;

use LIN3S\WPSymfonyForm\Translator;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;

class TwigBridge
{
    public static function addExtension($twig, $formTheme = 'form_div_layout.html.twig')
    {
        $formEngine = new TwigRendererEngine(array($formTheme));
        $twig->addExtension(
            new FormExtension(new TwigRenderer($formEngine))
        );

        $translator = Translator::getTranslator();

        $twig->addExtension(
            new TranslationExtension($translator)
        );

        return $twig;
    }
} 
