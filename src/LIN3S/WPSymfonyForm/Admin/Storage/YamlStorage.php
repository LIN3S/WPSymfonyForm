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
     * The logs collection.
     *
     * @var array
     */
    private $logs;

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
        $this->logs = Yaml::parse(file_get_contents($yamlFile));
    }

    /**
     * {@inheritdoc}
     */
    public function get($limit, $offset)
    {
        $logs = $this->all();
        usort($logs, [$this, 'sort']);

        return $this->paginate($logs, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function properties()
    {
        return array_keys($this->logs[0]);
    }

    /**
     * {@inheritdoc}
     */
    public function size()
    {
        return count($this->logs);
    }

    /**
     * Retrieve all the logs from YAML storage.
     *
     * @return array
     */
    private function all()
    {
        $logs = $this->logs;
        foreach ($logs as $key => $item) {
            if (array_key_exists('ID', $item)) {
                continue;
            }
            $logs[$key]['ID'] = $key;
        }

        return $logs;
    }

    /**
     * Paginates the given collection of logs.
     *
     * @param array $logs   The collection logs
     * @param int   $limit  Logs per page
     * @param int   $offset The number of the page
     *
     * @return array
     */
    private function paginate($logs, $limit, $offset)
    {
        return array_slice($logs, (($offset - 1) * $limit), $limit);
    }

    /**
     * Compares the given two logs.
     *
     * @param array $log1 The first log
     * @param array $log2 The second log
     *
     * @return int
     */
    private function sort($log1, $log2)
    {
        $orderBy = 'date';
        $order = 'asc';

        if (!empty($_GET['orderby'])) {
            $orderBy = $_GET['orderby'];
        }
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        }
        $result = strcmp($log1[$orderBy], $log2[$orderBy]);
        if ('asc' === $order) {
            return $result;
        }

        return -$result;
    }
}
