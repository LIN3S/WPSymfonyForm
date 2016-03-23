<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Twig;

use LIN3S\WPSymfonyForm\Translation\Translator;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;

/**
 * Twig bridge class.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class TwigBridge
{
    /**
     * @param mixed  $twig      The twig
     * @param string $formTheme The form theme
     *
     * @return mixed
     */
    public static function addExtension($twig, $formTheme = 'form_div_layout.html.twig')
    {
        $formEngine = new TwigRendererEngine([$formTheme]);
        $twig->addExtension(
            new FormExtension(new TwigRenderer($formEngine))
        );

        $twig->addExtension(
            new TranslationExtension(
                Translator::instance()
            )
        );

        return $twig;
    }
}
