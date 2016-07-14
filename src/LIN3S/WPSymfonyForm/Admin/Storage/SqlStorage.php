<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Admin\Storage;

/**
 * SQL strategy of storage.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class SqlStorage implements Storage
{
    /**
     * The WPDB instance.
     *
     * @var \wpdb
     */
    private $db;

    /**
     * The table name.
     *
     * @var string
     */
    private $table;

    /**
     * Constructor.
     *
     * @param string|null $formType The form type
     */
    public function __construct($formType = null)
    {
        global $wpdb;

        $this->db = $wpdb;
        $this->table = $this->table($formType);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($limit, $offset)
    {
        $sql = $this->db->prepare(
            "SELECT * FROM $this->table ORDER BY %s %s LIMIT %d OFFSET %d",
            $this->sort()['orderBy'],
            $this->sort()['order'],
            $limit,
            $offset - 1
        );

        return $this->db->get_results($sql, 'ARRAY_A');
    }

    /**
     * {@inheritdoc}
     */
    public function query(array $criteria, $limit, $offset)
    {
        $where = ' WHERE';
        foreach ($criteria as $criteriaName => $criteriaValue) {
            $where .= ' ' . $criteriaName . ' = ' . $criteriaValue;
        }
        if (count($criteria) === 0 || (count($criteria) === 1 && array_key_exists('formType', $criteria))) {
            return $this->findAll($limit, $offset);
        }

        $sql = $this->db->prepare(
            "SELECT * FROM $this->table $where ORDER BY %s %s LIMIT %d OFFSET %d",
            $this->sort()['orderBy'],
            $this->sort()['order'],
            $limit,
            $offset - 1
        );

        return $this->db->get_results($sql, 'ARRAY_A');
    }

    /**
     * {@inheritdoc}
     */
    public function properties()
    {
        $columns = [];
        foreach ($this->db->get_col('DESC ' . $this->table, 0) as $column) {
            $columns[] = $column;
        }

        return count($columns) > 0 ? $columns : null;
    }

    /**
     * {@inheritdoc}
     */
    public function size()
    {
        return $this->db->get_var("SELECT COUNT(*) FROM $this->table");
    }

    /**
     * Normalizes the order by of SQL part.
     *
     * @return array
     */
    private function sort()
    {
        $orderBy = 'name';
        $order = 'asc';

        if (!empty($_GET['orderby'])) {
            $orderBy = $_GET['orderby'];
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        }

        return ['orderBy' => $orderBy, 'order' => $order];
    }

    /**
     * Creates the table if not exist and returns the table name.
     *
     * @param string|null $formType   The form type
     * @param array       $columnData The column data
     *
     * @return string
     */
    public static function initSchema($formType, $columnData)
    {
        $columns = '';
        foreach ($columnData as $name => $column) {
            if ($column === reset($columnData)) {
                if ($column instanceof \DateTimeInterface) {
                    $columns .= $name . ' DATETIME NOT NULL';
                    continue;
                }
                $columns .= $name . ' VARCHAR(600)';
                continue;
            }
            if ($column instanceof \DateTimeInterface) {
                $columns .= $name . ' DATETIME NOT NULL';
                continue;
            }
            $columns .= ', ' . $name . ' VARCHAR(600)';
        }
        $sql = sprintf(
            'CREATE TABLE IF NOT EXISTS `' . self::table($formType) . '` (
 `id` int(10) NOT NULL AUTO_INCREMENT, %s, PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;',
            $columns
        );

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        return self::table($formType);
    }

    /**
     * Gets the built table of database.
     *
     * @param string|null $formType The form type
     *
     * @return string
     */
    private function table($formType)
    {
        return null === $formType
            ? 'wp_symfony_form_log'
            : 'wp_symfony_form_' . $formType . '_log';
    }
}
