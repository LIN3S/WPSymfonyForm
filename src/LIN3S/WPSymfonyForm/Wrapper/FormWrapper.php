<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Wrapper;

use LIN3S\WPSymfonyForm\Action\Action;

/**
 * FormWrapper class.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class FormWrapper
{
    /**
     * The fully qualified class name of form.
     *
     * @var string
     */
    protected $formClass;

    /**
     * The name of the form.
     *
     * @var string
     */
    protected $name;

    /**
     * Array of actions.
     *
     * @var array
     */
    protected $successActions;

    /**
     * Generates a wrapper for a given form.
     *
     * @param string   $name           The name of form
     * @param string   $formClass      Fqcn of form
     * @param Action[] $successActions Array of actions
     */
    public function __construct($name, $formClass, $successActions = [])
    {
        $this->formClass = $formClass;
        $this->name = $name;
        foreach ($successActions as $action) {
            if (!$action instanceof Action) {
                throw new \InvalidArgumentException(
                    'All actions passed to the FormWrapper must be an instance of Action'
                );
            }
        }
        $this->successActions = $successActions;
    }

    /**
     * Gets the fully qualified class name of the form.
     *
     * @return string
     */
    public function getForm()
    {
        return $this->formClass;
    }

    /**
     * Gets name of the form.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns registered actions to be called in form success.
     *
     * @return Action[]
     */
    public function getSuccessActions()
    {
        return $this->successActions;
    }
}
