<?php

/*
 * Plugin Name: WP Symfony Form
 * Plugin URI: http://lin3s.com
 * Description: WordPress plugin to allow using Symfony form component with ease
 * Author: LIN3S
 * Version: 0.4.0
 * Author URI: http://lin3s.com/
 */

new WPSymfonyForm();

/**
 * Plugin WPSymfonyForm entry point class.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
final class WPSymfonyForm
{
    const VERSION = '0.4.0';
    const TRANSLATION_DOMAIN = 'WP Symfony Form';

    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('init', [$this, 'loadPlugin']);
    }

    /**
     * Callback that allows to load the plugin.
     */
    public function loadPlugin()
    {
        $registry = apply_filters(
            'wp_symfony_form_wrappers',
            new \LIN3S\WPSymfonyForm\Registry\FormWrapperRegistry()
        );

        new \LIN3S\WPSymfonyForm\Ajax\FormSubmitAjax($registry);

        wp_enqueue_script(
            'wp-symfony-form',
            plugin_dir_url(__FILE__) . '/src/LIN3S/WPSymfonyForm/Resources/js/wp-symfony-form.js',
            ['jquery'],
            self::VERSION,
            true
        );

        wp_localize_script('wp-symfony-form', 'WPSymfonyFormSettings', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ]);

        \LIN3S\WPSymfonyForm\Admin\Admin::instance();
    }
}
