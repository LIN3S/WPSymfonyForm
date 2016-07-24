<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPSymfonyForm\Action;

use LIN3S\WPSymfonyForm\Action\Action;
use LIN3S\WPSymfonyForm\Action\MailerAction;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of MailerAction.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class MailerActionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('info@lin3s.com', '<html>The template</html>', 'The email subject');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MailerAction::class);
    }

    function it_implements_action()
    {
        $this->shouldImplement(Action::class);
    }
}
