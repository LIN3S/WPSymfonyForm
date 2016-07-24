<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Admin\Views\Components;

/**
 * Component base interface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
interface Component
{
    /**
     * Gets the instance of WP list table component.
     *
     * @return \WP_List_Table
     */
    public function load();
}
