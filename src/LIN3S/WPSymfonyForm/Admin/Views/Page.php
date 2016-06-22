<?php

namespace LIN3S\WPSymfonyForm\Admin\Views;

/**
 * Page base interface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
interface Page
{
    /**
     * Renders the page.
     */
    public function display();

    /**
     * Method that allows use "add_screen_option" WordPress hook
     * to add custom screen options inside current page.
     */
    public function screenOptions();
}
