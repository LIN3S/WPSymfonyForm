<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPSymfonyForm\Controller;

use fixtures\LIN3S\WPSymfonyForm\Form\Type\DummyType;
use LIN3S\WPSymfonyForm\Controller\AjaxController;
use LIN3S\WPSymfonyForm\Wrapper\FormWrapper;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of AjaxController.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class AjaxControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AjaxController::class);
    }

    function it_ajax_action(FormWrapper $formWrapper)
    {
        $formWrapper->getForm()->shouldBeCalled()->willReturn(DummyType::class);

        $this->ajaxAction($formWrapper);
    }
}
