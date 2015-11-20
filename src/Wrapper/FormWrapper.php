<?php

/*
 * This file is part of the WPSymfonyForm project.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LIN3S\WPSymfonyForm\Wrapper;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use LIN3S\WPSymfonyForm\Action\Interfaces\ActionInterface;
use LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface;

/**
 * Class FormWrapper
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class FormWrapper implements FormWrapperInterface
{
    /**
     * @var string
     */
    protected $formClass;

    /**
     * @var array
     */
    protected $successActions;

    /**
     * Generates a wrapper for a given form.
     *
     * @param string $formClass Fully qualified form class namespace
     * @param \LIN3S\WPSymfonyForm\Action\Interfaces\ActionInterface[]  $successActions Array of ActionInterfaces
     */
    public function __construct($formClass, $successActions = [])
    {
        $this->formClass = $formClass;
        foreach($successActions as $action) {
            if(!$action instanceof ActionInterface) {
                throw new InvalidArgumentException('All actions passed to the FormWrapper must be an instance of ActionInterface');
            }
        }
        $this->successActions = $successActions;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new $this->formClass();
    }

    /**
     * {@inheritdoc}
     */
    public function getSuccessActions()
    {
        return $this->successActions;
    }

}
