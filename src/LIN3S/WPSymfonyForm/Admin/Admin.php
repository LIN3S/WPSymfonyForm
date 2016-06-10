<?php

namespace LIN3S\WPSymfonyForm\Admin;

use LIN3S\WPSymfonyForm\Admin\Storage\InMemoryStorage;
use LIN3S\WPSymfonyForm\Admin\Storage\YamlStorage;
use LIN3S\WPSymfonyForm\Admin\Views\FormsTable;
use LIN3S\WPSymfonyForm\Admin\Views\LogsTable;
use LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry;

/**
 * Main admin class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class Admin
{
    /**
     * The forms table.
     *
     * @var FormsTable
     */
    private $formsTable;

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
    }

    /**
     * Loads the menu inside WordPress admin sidebar.
     */
    public function menu()
    {
        $menu = add_menu_page(
            'Symfony Forms',
            'Symfony Forms',
            'manage_options',
            'symfony-form',
            [$this, 'generalPage']
        );
        add_action("load-$menu", [$this, 'generalPageScreenOptions']);

        foreach ($this->formWrapperRegistry->get() as $key => $formWrapper) {
            $name = ucfirst($formWrapper->getName());
            $slug = 'wp-symfony-form-' . preg_replace('/\s+/', '', strtolower($formWrapper->getName()));

            $subMenu = add_submenu_page(
                'symfony-form',
                $name,
                $name,
                'manage_options',
                $slug,
                [$this, 'logArchivePage']
            );

            $this->forms[] = [
                'name' => $name,
                'link' => '<a href="?page=' . $slug . '">/wp-admin/admin.php?page=' . $slug . '</a>',
            ];

//            do_action('wp-symfony-form-load-'. $subMenu, ['name' => $name]);
//            add_action('wp-symfony-form-load-'. $subMenu, [$this, 'logArchivePageScreenOptions']);

//            add_action('wp-symfony-form-load-' . $subMenu, function () use ($name) {
//                add_screen_option('per_page', [
//                    'label'   => 'Logs',
//                    'default' => 10,
//                    'option'  => 'logs_per_page',
//                ]);
//
//                $this->logsTable = new LogsTable(
//                    $name,
//                    new YamlStorage()
//                );
//            });
        }
    }

    /**
     * Adds main form archive page screen options.
     */
    public function generalPageScreenOptions()
    {
        add_screen_option('per_page', [
            'label'   => 'Forms',
            'default' => 10,
            'option'  => 'forms_per_page',
        ]);

        $this->formsTable = new FormsTable(
            new InMemoryStorage(
                $this->forms
            )
        );
    }

//    /**
//     * Adds email log archive page screen options.
//     */
//    public function logArchivePageScreenOptions()
//    {
//        add_screen_option('per_page', [
//            'label'   => 'Logs',
//            'default' => 10,
//            'option'  => 'logs_per_page',
//        ]);
//
//        $this->logsTable = new LogsTable(
//            $
//            new YamlStorage()
//        );
//    }

    /**
     * Renders main form archive page.
     */
    public function generalPage()
    {
        ?>
        <div class="wrap">
            <h2><?php _e('General', \WPSymfonyForm::TRANSLATION_DOMAIN); ?></h2>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder">
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <form method="post">
                                <?php
                                $this->formsTable->prepare_items();
                                $this->formsTable->display(); ?>
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <?php
    }

    /**
     * Renders log archive page.
     */
    public function logArchivePage()
    {
        ?>
        <div class="wrap">
            <h2><?php _e('Sent emails logs', \WPSymfonyForm::TRANSLATION_DOMAIN); ?></h2>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder">
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <form method="post">
                                <?php
                                $this->logsTable->prepare_items();
                                $this->logsTable->display(); ?>
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <?php
    }
}
