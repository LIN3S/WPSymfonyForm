<?php

/*
 * This file is part of the WPSymfonyForm project.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Action\Interfaces;

use Symfony\Component\Form\FormInterface;

/**
 * Interface ActionInterface
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @package LIN3S\WPSymfonyForm\Action\Interfaces
 */
interface ActionInterface
{
    /**
     * Action to be executed
     *
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return mixed
     */
    public function execute(FormInterface $form);
}
