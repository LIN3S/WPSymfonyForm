<?php

namespace LIN3S\WPSymfonyForm\Admin;

use LIN3S\WPSymfonyForm\Admin\Storage\YamlStorage;
use LIN3S\WPSymfonyForm\Admin\Views\LogsTable;

/**
 * Main admin class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class Admin
{
    /**
     * The instance of the current class.
     *
     * @var self
     */
    private static $instance;

    /**
     * The logs table.
     *
     * @var LogsTable
     */
    public $logTable;

    /**
     * Singleton constructor.
     *
     * @return self
     */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct()
    {
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
            [$this, 'emailLogArchivePage']
        );

        add_action("load-$menu", [$this, 'screenOptions']);

    }

    /**
     * Adds screen options.
     */
    public function screenOptions()
    {
        add_screen_option('per_page', [
            'label'   => 'Logs',
            'default' => 10,
            'option'  => 'logs_per_page',
        ]);

        $this->logTable = new LogsTable(
            new YamlStorage()
        );
    }

    /**
     * Renders email log archive page.
     */
    public function emailLogArchivePage()
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
                                $this->logTable->prepare_items();
                                $this->logTable->display(); ?>
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
