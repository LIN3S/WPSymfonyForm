<?php

namespace LIN3S\WPSymfonyForm\Wrapper\Interfaces;

interface FormWrapperInterface
{
    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getForm();

    /**
     * @return \LIN3S\WPSymfonyForm\Action\Interfaces\ActionInterface[]
     */
    public function getSuccessActions();
}
