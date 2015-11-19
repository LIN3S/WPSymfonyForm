<?php

namespace LIN3S\WPSymfonyForm\Action\Interfaces;

use Symfony\Component\Form\FormInterface;

interface ActionInterface
{
    public function execute(FormInterface $form);
}
