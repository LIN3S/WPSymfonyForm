<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Controller;

use LIN3S\WPSymfonyForm\Factory\FormFactory;
use LIN3S\WPSymfonyForm\Translator;
use LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class AjaxController.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class AjaxController
{
    /**
     * Manages ajax call, if success executes success actions found in formWrapper
     *
     * @param \LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface $formWrapper
     *
     * @return string Javascript object notation (JSON) with the errors or empty if success
     */
    public function ajaxAction(FormWrapperInterface $formWrapper)
    {
        $form = FormFactory::get()->create($formWrapper->getForm());
        $form->handleRequest();

        if ($form->isValid()) {
            foreach ($formWrapper->getSuccessActions() as $action) {
                $action->execute($form);
            }

            return json_encode([]);
        } else {
            http_response_code(400);

            return json_encode($this->getFormErrors($form));
        }
    }

    /**
     * Returns serialized errors array
     *
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return array
     */
    protected function getFormErrors(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = Translator::getTranslator()->trans($error->getMessage(), [], 'validators');
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }

        return $errors;
    }
}
