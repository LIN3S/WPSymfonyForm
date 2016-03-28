<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPSymfonyForm\Translation;

use LIN3S\WPSymfonyForm\Translation\Translator;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of Translator.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class TranslatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Translator::class);
    }
}
