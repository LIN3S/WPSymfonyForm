<?php

namespace LIN3S\WPSymfonyForm\Admin\Views\Components;

use LIN3S\WPSymfonyForm\Admin\Storage\Storage;

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * Logs table.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class LogsTable extends \WP_List_Table
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
        parent::__construct([
            'singular' => __('Log', \WPSymfonyForm::TRANSLATION_DOMAIN),
            'plural'   => __('Logs', \WPSymfonyForm::TRANSLATION_DOMAIN),
            'ajax'     => false,
        ]);

        $this->formType = $formType;
        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function no_items()
    {
        _e('No emails sent yet', \WPSymfonyForm::TRANSLATION_DOMAIN);
    }

    /**
     * {@inheritdoc}
     */
    public function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    /**
     * {@inheritdoc}
     */
    public function get_columns()
    {
        if (null === $properties = $this->storage->properties()) {
            return [];
        }
        $columns = [];
        foreach ($this->storage->properties() as $property) {
            if ($property === 'formType') {
                continue;
            }
            $columns[$property] = __(ucfirst($property), \WPSymfonyForm::TRANSLATION_DOMAIN);
        }

        return $columns;
    }

    /**
     * {@inheritdoc}
     */
    public function get_sortable_columns()
    {
        return [
            'date'  => ['date', true],
            'email' => ['email', true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function prepare_items()
    {
        $this->_column_headers = $this->get_column_info();

        $limit = $this->get_items_per_page('logs_per_page', 10);
        $offset = $this->get_pagenum();
        $this->items = $this->storage->query(['formType' => $this->formType], $limit, $offset);

        $this->set_pagination_args([
            'total_items' => $this->storage->size(),
            'per_page'    => $limit,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function display()
    {
        ?>
        <div class="meta-box-sortables ui-sortable">
            <form action="" method="get">
                <?php
                $this->search_box(__('Search', \WPSymfonyForm::TRANSLATION_DOMAIN), 'search-id');
                foreach ($_GET as $key => $value) {
                    if ('s' !== $key) {
                        echo("<input type='hidden' name='$key' value='$value' />");
                    }
                }
                ?>
            </form>
            <form method="post">
                <?php parent::display(); ?>
            </form>
        </div>
        <?php
    }
}
