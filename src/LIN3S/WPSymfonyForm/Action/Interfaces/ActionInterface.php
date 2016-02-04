<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Action\Interfaces;

use Symfony\Component\Form\FormInterface;

/**
 * Interface ActionInterface.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
