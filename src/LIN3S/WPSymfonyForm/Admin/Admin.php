<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Admin;

use LIN3S\WPSymfonyForm\Action\ActionNotFoundException;
use LIN3S\WPSymfonyForm\Action\DatabaseStorageAction;
use LIN3S\WPSymfonyForm\Action\LocalStorageAction;
use LIN3S\WPSymfonyForm\Admin\Storage\InMemoryStorage;
use LIN3S\WPSymfonyForm\Admin\Storage\SqlStorage;
use LIN3S\WPSymfonyForm\Admin\Storage\Storage;
use LIN3S\WPSymfonyForm\Admin\Storage\YamlStorage;
use LIN3S\WPSymfonyForm\Admin\Views\Components\FormsTable;
use LIN3S\WPSymfonyForm\Admin\Views\Components\LogsTable;
use LIN3S\WPSymfonyForm\Admin\Views\Form;
use LIN3S\WPSymfonyForm\Admin\Views\General;
use LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry;
use LIN3S\WPSymfonyForm\Wrapper\FormWrapper;

/**
 * Main admin class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class Admin
{
    /**
     * The form wrapper registry.
     *
     * @var FormWrapperRegistry
     */
    private $formWrapperRegistry;

    /**
     * Array which contains the forms.
     *
     * @var array
     */
    private $forms;

    /**
     * Constructor.
     *
     * @param FormWrapperRegistry $formWrapperRegistry The form wrapper registry
     */
    public function __construct(FormWrapperRegistry $formWrapperRegistry)
    {
        $this->formWrapperRegistry = $formWrapperRegistry;
        $this->forms = [];
        add_filter('set-screen-option', function ($status, $option, $value) {
            return $value;
        }, 10, 3);

        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_menu', [$this, 'subMenu']);
    }

    /**
     * Loads the menu inside WordPress admin sidebar.
     */
    public function menu()
    {
        $view = new General(
            new FormsTable(
                new InMemoryStorage(
                    $this->forms()
                )
            )
        );

        $menu = add_menu_page(
            'Symfony Forms',
            'Symfony Forms',
            'manage_options',
            'symfony-form',
            [$view, 'display']
        );
        add_action("load-$menu", [$view, 'screenOptions']);

        add_submenu_page(
            'symfony-form',
            __('General', \WPSymfonyForm::TRANSLATION_DOMAIN),
            __('General', \WPSymfonyForm::TRANSLATION_DOMAIN),
            'manage_options',
            'symfony-form'
        );
    }

    /**
     * Loads the form sub menus inside WordPress admin sidebar.
     */
    public function subMenu()
    {
        foreach ($this->formWrapperRegistry->get() as $key => $formWrapper) {
            $slug = 'wp-symfony-form-' . preg_replace('/\s+/', '', strtolower($formWrapper->getName()));
            $name = ucfirst($formWrapper->getName());
            $view = new Form(
                $name,
                new LogsTable(
                    $formWrapper->getName(),
                    $this->storage($formWrapper)
                )
            );

            $subMenu = add_submenu_page(
                'symfony-form',
                $name,
                $name,
                'manage_options',
                $slug,
                [$view, 'display']
            );
            add_action("load-$subMenu", [$view, 'screenOptions']);
        }
    }

    /**
     * Resolves and gets the proper storage for the given form wrapper.
     *
     * @param FormWrapper $formWrapper The form wrapper
     *
     * @throws ActionNotFoundException when required action type not found
     *
     * @return Storage
     */
    private function storage(FormWrapper $formWrapper)
    {
        foreach ($formWrapper->getSuccessActions() as $action) {
            if ($action instanceof LocalStorageAction) {
                return new YamlStorage($formWrapper->getName());
            }
            if ($action instanceof DatabaseStorageAction) {
                return new SqlStorage($formWrapper->getName());
            }
        }

        throw new ActionNotFoundException();
    }

    /**
     * Populates the forms with its name and its link, returning the built array.
     *
     * @return array
     */
    private function forms()
    {
        if (!empty($this->forms)) {
            return $this->forms;
        }

        foreach ($this->formWrapperRegistry->get() as $key => $formWrapper) {
            $slug = 'wp-symfony-form-' . preg_replace('/\s+/', '', strtolower($formWrapper->getName()));
            $name = ucfirst($formWrapper->getName());

            $this->forms[] = [
                'name' => $name,
                'link' => '<a href="?page=' . $slug . '">/wp-admin/admin.php?page=' . $slug . '</a>',
            ];
        }

        return $this->forms;
    }
}
