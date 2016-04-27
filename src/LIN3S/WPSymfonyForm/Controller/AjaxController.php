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
use LIN3S\WPSymfonyForm\Translation\Translator;
use LIN3S\WPSymfonyForm\Wrapper\FormWrapper;
use Symfony\Component\Form\FormInterface;

/**
 * The controller that resolves AJAX call.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class AjaxController
{
    /**
     * Manages ajax call, if success executes success actions found in formWrapper.
     *
     * @param FormWrapper $formWrapper The form wrapper
     *
     * @return string
     */
    public function ajaxAction(FormWrapper $formWrapper)
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
     * Returns serialized errors array.
     *
     * @param FormInterface $form The form
     *
     * @return array
     */
    protected function getFormErrors(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = Translator::instance()->trans($error->getMessageTemplate(), $error->getMessageParameters(), 'validators');
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }

        return $errors;
    }
}
