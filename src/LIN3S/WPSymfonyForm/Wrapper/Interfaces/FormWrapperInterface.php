<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Wrapper\Interfaces;

/**
 * Interface FormWrapperInterface.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface FormWrapperInterface
{
    /**
     * Returns a new instance of the Form
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm();

    /**
     * Returns registered actions to be called in form success
     *
     * @return \LIN3S\WPSymfonyForm\Action\Interfaces\ActionInterface[]
     */
    public function getSuccessActions();
}
