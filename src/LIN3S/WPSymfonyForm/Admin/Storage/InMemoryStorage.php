<?php

namespace LIN3S\WPSymfonyForm\Admin\Storage;

use Symfony\Component\Yaml\Yaml;

/**
 * In memory strategy of storage.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class InMemoryStorage implements Storage
{
    /**
     * The data collection.
     *
     * @var array
     */
    private $data;

    /**
     * Constructor.
     *
     * @param mixed $data The data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($limit, $offset)
    {
        $data = $this->data;
        foreach ($data as $key => $item) {
            if (array_key_exists('ID', $item)) {
                continue;
            }
            $data[$key]['ID'] = $key;
        }
        usort($data, [$this, 'sort']);

        return $this->paginate($data, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function query(array $criteria, $limit, $offset)
    {
        $data = [];
        foreach ($this->data as $key => $item) {
            foreach ($criteria as $name => $singleCriteria) {
                if ($item[$name] === $singleCriteria) {
                    $data[$key] = $item;
                }
            }
            if (array_key_exists('ID', $item)) {
                continue;
            }
            $data[$key]['ID'] = $key;
        }
        usort($data, [$this, 'sort']);

        return $this->paginate($data, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function properties()
    {
        if (is_array($this->data[0])) {
            return array_keys($this->data[0]);
        }

        return array_keys($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function size()
    {
        return count($this->data);
    }

    /**
     * Paginates the given collection of data.
     *
     * @param array $data   The collection data
     * @param int   $limit  Logs per page
     * @param int   $offset The number of the page
     *
     * @return array
     */
    private function paginate($data, $limit, $offset)
    {
        return array_slice($data, (($offset - 1) * $limit), $limit);
    }

    /**
     * Compares the given two items.
     *
     * @param mixed $item1 The first item
     * @param mixed $item2 The second item
     *
     * @return int
     */
    private function sort($item1, $item2)
    {
        $orderBy = 'name';
        $order = 'asc';

        if (!empty($_GET['orderby'])) {
            $orderBy = $_GET['orderby'];
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        }
        $result = strcmp($item1[$orderBy], $item2[$orderBy]);
        if ('asc' === $order) {
            return $result;
        }

        return -$result;
    }
}
