<?php

/*
 * This file is part of the WPSymfonyForm project.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Twig;

use LIN3S\WPSymfonyForm\Translator;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;

/**
 * Class TwigBridge
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @package LIN3S\WPSymfonyForm\Twig
 */
class TwigBridge
{
    /**
     * @param        $twig
     * @param string $formTheme
     *
     * @return mixed
     */
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
