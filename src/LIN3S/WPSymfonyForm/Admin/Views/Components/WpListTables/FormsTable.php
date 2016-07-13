<?php

namespace LIN3S\WPSymfonyForm\Admin\Views\Components\WpListTables;

use LIN3S\WPSymfonyForm\Admin\Storage\Storage;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Forms table.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class FormsTable extends \WP_List_Table
{
    /**
     * The storage.
     *
     * @var Storage
     */
    private $storage;

    /**
     * Constructor.
     *
     * @param Storage $storage The storage
     */
    public function __construct(Storage $storage)
    {
        parent::__construct([
            'singular' => __('Form', \WPSymfonyForm::TRANSLATION_DOMAIN),
            'plural'   => __('Forms', \WPSymfonyForm::TRANSLATION_DOMAIN),
            'ajax'     => false,
        ]);

        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function no_items()
    {
        _e('No forms register yet', \WPSymfonyForm::TRANSLATION_DOMAIN);
    }

    /**
     * {@inheritdoc}
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'name':
            case 'link':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get_columns()
    {
        return [
            'name' => __('Name', \WPSymfonyForm::TRANSLATION_DOMAIN),
            'link' => __('Link', \WPSymfonyForm::TRANSLATION_DOMAIN),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function get_sortable_columns()
    {
        return [
            'name' => ['name', true],
            'link' => ['link', false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function prepare_items()
    {
        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
        $this->_column_headers = $this->get_column_info();

        $limit = $this->get_items_per_page('forms_per_page', 10);
        $offset = $this->get_pagenum();
        $this->items = $this->storage->findAll($limit, $offset);
        $total = count($this->items);

        $this->set_pagination_args([
            'total_items' => $total,
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
            <form method="post">
                <?php parent::display(); ?>
            </form>
        </div>
        <?php

    }
}
