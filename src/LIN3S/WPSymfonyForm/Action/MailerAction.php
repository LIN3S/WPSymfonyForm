<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Action;

use Symfony\Component\Form\FormInterface;

/**
 * Class MailerAction.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class MailerAction implements Action
{
    /**
     * The email subject.
     *
     * @var string
     */
    private $subject;

    /**
     * The email HTML template.
     *
     * @var string
     */
    private $template;

    /**
     * The receiver email.
     *
     * @var string
     */
    private $to;

    /**
     * Constructor.
     *
     * @param string $to       The receiver email
     * @param string $template The email HTML template
     * @param string $subject  The email subject
     */
    public function __construct($to, $template, $subject)
    {
        $this->to = $to;
        $this->template = $template;
        $this->subject = $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(FormInterface $form)
    {
        if (!class_exists('\Timber')) {
            throw new \InvalidArgumentException('Timber plugin is required to use MailerAction');
        }

        $message = \Timber::compile($this->template, ['request' => $form->getData()]);

        wp_mail($this->to, $this->subject, $message, [
            'Content-Type: text/html; charset=UTF-8',
        ]);
    }
}
