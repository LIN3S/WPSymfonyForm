<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPSymfonyForm\Wrapper;

use fixtures\LIN3S\WPSymfonyForm\Form\Type\DummyType;
use LIN3S\WPSymfonyForm\Wrapper\FormWrapper;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of FormWrapper.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class FormWrapperSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('dummy', DummyType::class, []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FormWrapper::class);
    }

    function it_gets_form()
    {
        $this->getForm()->shouldReturn(DummyType::class);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('dummy');
    }

    function it_gets_success_actions()
    {
        $this->getSuccessActions()->shouldBeArray();
    }
}
