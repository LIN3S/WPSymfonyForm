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
     * Retrieves the data data using the given pagination options.
     *
     * @param int $limit  The logs per page
     * @param int $offset The page number
     *
     * @return mixed
     */
    public function findAll($limit, $offset);

    /**
     * Retrieves the data of given criteria using the given pagination options.
     *
     * @param array $criteria The filter criteria
     * @param int   $limit    The logs per page
     * @param int   $offset   The page number
     *
     * @return mixed
     */
    public function query(array $criteria, $limit, $offset);

    /**
     * Gets the properties that contain each data.
     *
     * @return array
     */
    public function properties();

    /**
     * Counts the data.
     *
     * @return int
     */
    public function size();
}
