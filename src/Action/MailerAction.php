<?php

namespace LIN3S\WPSymfonyForm\Action;

use LIN3S\WPSymfonyForm\Action\Interfaces\ActionInterface;
use Symfony\Component\Form\FormInterface;

class MailerAction implements ActionInterface
{
    private $to;

    private $template;

    private $subject;

    public function __construct($to, $template, $subject) {
        $this->to = $to;
        $this->template = $template;
        $this->subject = $subject;
    }

    public function execute(FormInterface $form)
    {
        $message = \Timber::compile($this->template, ['request' => $form->getData()]);

        wp_mail($this->to, $this->subject, $message, [
            'Content-Type: text/html; charset=UTF-8',
        ]);
    }
}
