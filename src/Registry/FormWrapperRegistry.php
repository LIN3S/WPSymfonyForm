<?php

/*
 * This file is part of the WPSymfonyForm project.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Registry;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface;

/**
 * Class FormWrapperRegistry
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class FormWrapperRegistry
{
    protected $formWrappers;

    /**
     * Initializes the registry with an array of wrappers
     *
     * @param FormWrapperInterface[] $formWrappers
     */
    public function __construct($formWrappers = [])
    {
        if (is_array($formWrappers)) {
            foreach ($formWrappers as $wrapper) {
                if (!$wrapper instanceof FormWrapperInterface) {
                    throw new InvalidArgumentException(sprintf(
                        'FormWrapperRegistry requires an array of FormWrapperInterface objects, %s given',
                        get_class($wrapper)
                    ));
                }
            }
            $this->formWrappers = $formWrappers;
        } else {
            throw new InvalidArgumentException(sprintf(
                'FormWrapperRegistry requires an array of FormWrapperInterface objects, %s given',
                get_class($formWrappers)
            ));
        }
    }

    /**
     * Gets a form wrapper by form name
     *
     * @param string $formName
     *
     * @throw \InvalidArgumentException if wrapper not found
     * @return \LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface
     */
    public function get($formName)
    {
        /** @var FormWrapperInterface $wrapper */
        foreach ($this->formWrappers as $wrapper) {
            if ($wrapper->getForm()->getName() === $formName) {
                return $wrapper;
            }
        }

        throw new \InvalidArgumentException(sprintf(
            'Form with name %s not found in FormWrapperRegistry',
            $formName
        ));
    }

    /**
     * Adds a form wrapper to the registry
     *
     * @param \LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface $formWrapper
     *
     * @return \LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface
     */
    public function add(FormWrapperInterface $formWrapper) {
        $this->formWrappers[] = $formWrapper;
    }
}
