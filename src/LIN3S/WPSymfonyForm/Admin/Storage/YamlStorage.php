<?php

namespace LIN3S\WPSymfonyForm\Admin\Storage;

use Symfony\Component\Yaml\Yaml;

/**
 * YAML strategy of storage.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class YamlStorage implements Storage
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
     * @param string $yamlFile The dir path of YAML file
     */
    public function __construct($yamlFile = null)
    {
        if (null === $yamlFile) {
            $yamlFile = __DIR__ . '/../../../../../../../../wp_symfony_form_email_log.yml';
        }
        $this->data = Yaml::parse(file_get_contents($yamlFile));
        if (null === $this->data) {
            $this->data = [];
        }
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
        return isset($this->data[0]) ? array_keys($this->data[0]) : null;
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
