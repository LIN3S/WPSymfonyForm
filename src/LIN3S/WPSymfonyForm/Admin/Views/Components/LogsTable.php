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
use LIN3S\WPSymfonyForm\Admin\Views\Components\WpListTables\LogsTable as WPLogsTable;

/**
 * Logs table.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class LogsTable implements Component
{
    /**
     * The storage.
     *
     * @var Storage
     */
    private $storage;

    /**
     * The form type name.
     *
     * @var string
     */
    private $formType;

    /**
     * Constructor.
     *
     * @param string  $formType The form type name
     * @param Storage $storage  The storage
     */
    public function __construct($formType, Storage $storage)
    {
        $this->formType = $formType;
        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        return new WPLogsTable($this->formType, $this->storage);
    }
}
