<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPSymfonyForm\Ajax;

use LIN3S\WordPressPhpSpecBridge\ObjectBehavior;
use LIN3S\WPSymfonyForm\Ajax\FormSubmitAjax;
use LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry;

/**
 * Spec file of FormSubmitAjax.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class FormSubmitAjaxSpec extends ObjectBehavior
{
    function let(FormWrapperRegistry $formWrapperRegistry)
    {
        $this->beConstructedWith($formWrapperRegistry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FormSubmitAjax::class);
    }
}
