<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Registry;

use LIN3S\WPSymfonyForm\Wrapper\FormWrapper;

/**
 * FormWrapperRegistry class.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class FormWrapperRegistry
{
    /**
     * Collection of form wrappers.
     *
     * @var FormWrapper[]
     */
    private $formWrappers;

    /**
     * Initializes the registry with an array of wrappers.
     *
     * @param FormWrapper[] $formWrappers The form wrappers collection
     */
    public function __construct(array $formWrappers = [])
    {
        $this->formWrappers = array_map(function (FormWrapper $formWrapper) {
            return $formWrapper;
        }, $formWrappers);
    }

    /**
     * Gets a form wrapper by form name.
     *
     * @param string $formName The form name
     *
     * @throw \InvalidArgumentException if wrapper not found
     *
     * @return FormWrapper
     */
    public function get($formName)
    {
        foreach ($this->formWrappers as $wrapper) {
            if ($wrapper->getName() === $formName) {
                return $wrapper;
            }
        }
        throw new \InvalidArgumentException(
            sprintf(
                'Form with name %s not found in FormWrapperRegistry',
                $formName
            )
        );
    }

    /**
     * Adds a form wrapper to the registry.
     *
     * @param FormWrapper $formWrapper The form wrapper
     */
    public function add(FormWrapper $formWrapper)
    {
        $this->formWrappers[] = $formWrapper;
    }
}
