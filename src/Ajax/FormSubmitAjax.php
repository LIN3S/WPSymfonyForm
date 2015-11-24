<?php

/*
 * This file is part of the WPSymfonyForm project.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
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
 * @package LIN3S\WPSymfonyForm\Ajax
 */
class FormSubmitAjax
{
    /**
     * @var string Action used by WordPress to identify this AJAX request
     */
    protected $action = 'form_submit';

    /**
     * @var \LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry
     */
    protected $formWrapperRegistry;

    /**
     * Constructor.
     *
     * @param \LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry $formWrapperRegistry
     */
    public function __construct(FormWrapperRegistry $formWrapperRegistry) {
        add_action('wp_ajax_nopriv_' . $this->action, [$this, 'ajax']);
        add_action('wp_ajax_' . $this->action, [$this, 'ajax']);
        $this->formWrapperRegistry = $formWrapperRegistry;
    }

    /**
     * Call to be executed on AJAX request
     */
    public function ajax()
    {
        $controller = new AjaxController();

        try {
            unset($_POST['action']);
            if(count($_POST) !== 1) {
                throw new \InvalidArgumentException();
            }
            $formType = key($_POST);
            $formWrapper = $this->formWrapperRegistry->get($formType);
            unset($_POST['form_type']);
            unset($_POST['action']);
            echo $controller->ajaxAction($formWrapper);
            die();
        } catch(\InvalidArgumentException $e) {
            echo json_encode(["errors" => ["unknown form_type"]]);
            http_response_code(400);
            die();
        }
    }
}
