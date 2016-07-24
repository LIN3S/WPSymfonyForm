<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
