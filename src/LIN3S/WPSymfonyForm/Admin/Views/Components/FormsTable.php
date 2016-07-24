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

use LIN3S\WPSymfonyForm\Admin\Storage\Storage;
use LIN3S\WPSymfonyForm\Admin\Views\Components\WpListTables\FormsTable as WPFormsTable;

/**
 * Forms table.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class FormsTable implements Component
{
    /**
     * The storage.
     *
     * @var Storage
     */
    private $storage;

    /**
     * Constructor.
     *
     * @param Storage $storage The storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        return new WPFormsTable($this->storage);
    }
}
