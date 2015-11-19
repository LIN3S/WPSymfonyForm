<?php

/*
 * This file is part of the Euskalduna project.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Controller;

use LIN3S\WPSymfonyForm\Forms;
use LIN3S\WPSymfonyForm\Translator;
use LIN3S\WPSymfonyForm\Wrapper\Interfaces\FormWrapperInterface;
use Symfony\Component\Form\FormInterface;

class AjaxController
{
    public function ajaxAction(FormWrapperInterface $formWrapper)
    {
        $form = Forms::createFormFactory()->create($formWrapper->getForm());
        $form->handleRequest();

        if ($form->isValid()) {
            foreach($formWrapper->getSuccessActions() as $action) {
                $action->execute($form);
            }

            return json_encode([]);
        } else {
            http_response_code(400);
            return json_encode($this->getFormErrors($form));
        }
    }

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
