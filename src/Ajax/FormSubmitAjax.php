<?php

namespace LIN3S\WPSymfonyForm\Ajax;

use LIN3S\WPFoundation\Ajax\Ajax;
use LIN3S\WPSymfonyForm\Controller\AjaxController;
use LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry;

/**
 * Form submit ajax class.
 *
 * @author Gorka Laucirica <gorka@lin3s.com>
 */
class FormSubmitAjax extends Ajax
{
    protected $action = 'form_submit';

    protected $formWrapperRegistry;

    public function __construct(FormWrapperRegistry $formWrapperRegistry) {
        parent::__construct();
        $this->formWrapperRegistry = $formWrapperRegistry;
    }

    public function ajax()
    {
        $controller = new AjaxController();

        try {
            $formWrapper = $this->formWrapperRegistry->get($_POST['form_type']);
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
