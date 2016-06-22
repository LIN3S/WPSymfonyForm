<?php

namespace LIN3S\WPSymfonyForm\Admin;

use LIN3S\WPSymfonyForm\Admin\Storage\InMemoryStorage;
use LIN3S\WPSymfonyForm\Admin\Storage\Storage;
use LIN3S\WPSymfonyForm\Admin\Storage\YamlStorage;
use LIN3S\WPSymfonyForm\Admin\Views\Form;
use LIN3S\WPSymfonyForm\Admin\Views\Components\FormsTable;
use LIN3S\WPSymfonyForm\Admin\Views\Components\LogsTable;
use LIN3S\WPSymfonyForm\Admin\Views\General;
use LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry;

/**
 * Main admin class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class Admin
{
    /**
     * The logs table.
     *
     * @var LogsTable
     */
    public $logsTable;

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
     * The storage strategy.
     *
     * @var Storage
     */
    private $storage;

    /**
     * Constructor.
     *
     * @param FormWrapperRegistry $formWrapperRegistry The form wrapper registry
     */
    public function __construct(FormWrapperRegistry $formWrapperRegistry)
    {
        $this->storage = new YamlStorage(); // TODO: This is hardcoded for now
        $this->formWrapperRegistry = $formWrapperRegistry;
        $this->forms = [];
        add_filter('set-screen-option', function ($status, $option, $value) {
            return $value;
        }, 10, 3);

        add_action('admin_menu', [$this, 'menu']);
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
        foreach ($this->formWrapperRegistry->get() as $key => $formWrapper) {
            $slug = 'wp-symfony-form-' . preg_replace('/\s+/', '', strtolower($formWrapper->getName()));
            $name = ucfirst($formWrapper->getName());
            $view = new Form(
                $name,
                new LogsTable(
                    $formWrapper->getName(),
                    $this->storage
                )
            );

            $subMenu = add_submenu_page('symfony-form', $name, $name, 'manage_options', $slug, function () use ($view) {
                $view->display();
            });
            add_action("load-$subMenu", [$view, 'screenOptions']);
        }
    }

    public function forms()
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
