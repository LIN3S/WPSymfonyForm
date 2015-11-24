<?php

/*
 * Plugin Name: WP Symfony Form
 * Plugin URI: http://lin3s.com
 * Description: Allows using forms the Symfony way
 * Author: LIN3S
 * Version: 0.2.0
 * Author URI: http://lin3s.com/
 */

new WPSymfonyForm();

/**
 * Plugin WPSymfonyForm class.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class WPSymfonyForm
{
    const VERSION = '0.2.0';

    /**
     * Construtor.
     */
    public function __construct()
    {
        add_action('init', [$this, 'loadPlugin']);
    }

    /**
     * Loads plugin
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
            plugin_dir_url( __FILE__ ) . '/src/Resources/js/wp-symfony-form.js',
            ['jquery'],
            self::VERSION,
            true
        );

        wp_localize_script('wp-symfony-form', 'WPSymfonyFormSettings', [
            'ajaxUrl'      => admin_url('admin-ajax.php'),
        ]);
    }
}
