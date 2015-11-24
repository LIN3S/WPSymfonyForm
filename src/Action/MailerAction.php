<?php

/*
 * This file is part of the WPSymfonyForm project.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Action;

use LIN3S\WPSymfonyForm\Action\Interfaces\ActionInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class MailerAction
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @package LIN3S\WPSymfonyForm\Action
 */
class MailerAction implements ActionInterface
{
    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $subject;

    /**
     * Constructor.
     *
     * @param string $to       Mail recipient
     * @param string $template Twig template
     * @param string $subject  Subject of the mail
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
        if(!class_exists('\Timber')) {
            throw new \InvalidArgumentException('Timber plugin is required to use MailerAction');
        }

        $message = \Timber::compile($this->template, ['request' => $form->getData()]);

        wp_mail($this->to, $this->subject, $message, [
            'Content-Type: text/html; charset=UTF-8',
        ]);
    }
}
