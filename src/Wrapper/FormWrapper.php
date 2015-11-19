<?php

namespace LIN3S\WPSymfonyForm\Wrapper;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use LIN3S\WPSymfonyForm\Action\Interfaces\ActionInterface;
use LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface;

class FormWrapper implements FormWrapperInterface
{
    protected $formClass;

    protected $successActions;

    /**
     * Generates a wrapper for a given form.
     *
     * @param string $formClass Fully qualified form class namespace
     * @param array  $successActions Array of ActionInterfaces
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
