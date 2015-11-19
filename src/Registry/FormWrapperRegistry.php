<?php

namespace LIN3S\WPSymfonyForm\Registry;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface;

class FormWrapperRegistry
{
    protected $formWrappers;

    /**
     * Initializes the registry with an array of wrappers
     *
     * @param array $formWrappers
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
     * @param $formName
     *
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
}
