<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Action;

use LIN3S\WPSymfonyForm\Admin\Storage\SqlStorage;
use Symfony\Component\Form\FormInterface;

/**
 * Database storage action.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class DatabaseStorageAction implements Action
{
    /**
     * The WPDB instance.
     *
     * @var \wpdb
     */
    private $db;

    /**
     * Constructor.
     */
    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(FormInterface $form)
    {
        $data = array_merge([
            'date' => (new \DateTimeImmutable())->format('Y-m-d - h:m'),
        ], $form->getData());

        $table = SqlStorage::initSchema($form->getName(), $data);

        $this->db->insert($table, $data);
    }
}
