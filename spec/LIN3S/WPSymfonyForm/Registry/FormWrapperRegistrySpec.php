<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPSymfonyForm\Registry;

use fixtures\LIN3S\WPSymfonyForm\Form\Type\DummyType;
use LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry;
use LIN3S\WPSymfonyForm\Wrapper\FormWrapper;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of FormWrapperRegistry.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class FormWrapperRegistrySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            new FormWrapper('dummy', DummyType::class),
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FormWrapperRegistry::class);
    }

    function it_gets()
    {
        $this->get('dummy')->shouldReturnAnInstanceOf(FormWrapper::class);
    }

    function it_does_not_get_because_the_form_wrapper_does_not_exist()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringGet('non-exist-wrapper');
    }

    function it_adds()
    {
        $formWrapper = new FormWrapper('new-wrapper', DummyType::class);

        $this->shouldThrow(\InvalidArgumentException::class)->duringGet('new-wrapper');
        $this->add($formWrapper);
        $this->get('new-wrapper')->shouldReturn($formWrapper);
    }
}
