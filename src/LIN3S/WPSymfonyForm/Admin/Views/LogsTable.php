<?php

namespace LIN3S\WPSymfonyForm\Admin\Views;

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
        add_action('admin_head', [$this, 'header']);
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
        $columns = [];
        foreach ($this->storage->properties() as $property) {
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
        $total = count($this->items);

        $this->set_pagination_args([
            'total_items' => $total,
            'per_page'    => $limit,
        ]);
    }

    /**
     * Callback that customize the header of the table.
     */
    public function header()
    {
        echo <<<EOL
<style type="text/css">
    .wp-list-table .column-date {
        width: 15%;
    }

    .wp-list-table .column-email {
        width: 15%;
    }

    .wp-list-table .column-comment {
        width: 30%;
    }
    
    .wp-list-table .column-message {
        width: 30%;
    }
</style>
EOL;
    }
}
