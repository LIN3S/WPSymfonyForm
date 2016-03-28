<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPSymfonyForm\Factory;

use LIN3S\WPSymfonyForm\Factory\FormFactory;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Spec file of FormFactory.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class FormFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FormFactory::class);
    }

    function it_get()
    {
        $this::get()->shouldReturnAnInstanceOf(FormFactoryInterface::class);
    }
}
