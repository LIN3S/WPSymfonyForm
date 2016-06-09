<?php

namespace LIN3S\WPSymfonyForm\Admin\Storage;

/**
 * Storage base interface to make easily different strategies.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
interface Storage
{
    /**
     * Retrieves the logs data using the given pagination options.
     *
     * @param int $limit  The logs per page
     * @param int $offset The page number
     *
     * @return mixed
     */
    public function get($limit, $offset);

    /**
     * Gets the properties that contain each log.
     *
     * @return array
     */
    public function properties();

    /**
     * Counts the logs.
     *
     * @return int
     */
    public function size();
}
