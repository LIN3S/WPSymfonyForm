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
     * The pdo instance.
     *
     * @var \PDO
     */
    private $pdo;

    /**
     * The table name.
     *
     * @var string
     */
    private $table;

    /**
     * Constructor.
     *
     * @param \PDO        $aPdo     The pdo instance
     * @param string|null $formType The form type
     */
    public function __construct(\PDO $aPdo, $formType = null)
    {
        $this->pdo = $aPdo;
        $this->table = null === $formType
            ? 'wp_symfony_form_log'
            : 'wp_symfony_form_' . $formType . '_log';
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($limit, $offset)
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' LIMIT :offset, :limit ORDER BY :orderBy :order');
        $statement->execute(
            array_merge(
                [
                    'offset' => $offset,
                    'limit'  => $limit,
                ],
                $this->sort()
            )
        );

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritdoc}
     */
    public function query(array $criteria, $limit, $offset)
    {
        $where = ' WHERE';
        foreach ($criteria as $singleCriteria) {
            $where .= ' :' . $singleCriteria;
        }

        $statement = $this->pdo->prepare('SELECT * FROM ' . $this->table . $where . ' LIMIT :offset, :limit ORDER BY :orderBy :order');
        $statement->execute(
            array_merge(
                $criteria,
                [
                    'offset' => $offset,
                    'limit'  => $limit,
                ],
                $this->sort()
            )
        );

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritdoc}
     */
    public function properties()
    {
        $columns = [];
        $result = $this->pdo->query('SELECT * FROM ' . $this->table . ' LIMIT 0');
        for ($i = 0; $i < $result->columnCount(); $i++) {
            $meta = $result->getColumnMeta($i);
            $columns[] = $meta['name'];
        }

        return count($columns) > 0 ? $columns : null;
    }

    /**
     * {@inheritdoc}
     */
    public function size()
    {
        return
            $this->pdo
                ->query('SELECT COUNT(*) FROM ' . $this->table)
                ->fetchColumn();
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
}
