<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Ajax;

use LIN3S\WPSymfonyForm\Controller\AjaxController;
use LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry;

/**
 * Form submit ajax class.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class FormSubmitAjax
{
    /**
     * The form wrapper registry.
     *
     * @var FormWrapperRegistry
     */
    private $formWrapperRegistry;

    /**
     * Constructor.
     *
     * @param FormWrapperRegistry $formWrapperRegistry The form wrapper registry
     * @param string              $action              Action used by WordPress to identify this AJAX request
     */
    public function __construct(FormWrapperRegistry $formWrapperRegistry, $action = 'form_submit')
    {
        add_action('wp_ajax_nopriv_' . $action, [$this, 'ajax']);
        add_action('wp_ajax_' . $action, [$this, 'ajax']);
        $this->formWrapperRegistry = $formWrapperRegistry;
    }

    /**
     * Call to be executed on AJAX request.
     */
    public function ajax()
    {
        try {
            unset($_POST['action']);
            if (count($_POST) !== 1) {
                throw new \InvalidArgumentException();
            }

            $formType = key($_POST);
            $formWrapper = $this->formWrapperRegistry->get($formType);
            echo(new AjaxController())->ajaxAction($formWrapper);
            die();
        } catch (\InvalidArgumentException $exception) {
            echo json_encode(['errors' => ['unknown form_type']]);
            http_response_code(400);
            die();
        }
    }
}
