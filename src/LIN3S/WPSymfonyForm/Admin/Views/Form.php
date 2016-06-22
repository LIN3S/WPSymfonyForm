<?php

namespace LIN3S\WPSymfonyForm\Admin\Views;

use LIN3S\WPSymfonyForm\Admin\Views\Components\LogsTable;

/**
 * Single form page.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class Form implements Page
{
    /**
     * The logs table component.
     *
     * @var LogsTable
     */
    private $logsTable;

    /**
     * The form type name.
     *
     * @var string
     */
    private $formType;

    /**
     * Constructor.
     *
     * @param string    $formType  The form type name
     * @param LogsTable $logsTable The logs table component
     */
    public function __construct($formType, LogsTable $logsTable)
    {
        $this->formType = $formType;
        $this->logsTable = $logsTable;
    }

    /**
     * {@inheritdoc}
     */
    public function display()
    {
        $this->logsTable->prepare_items();

        ?>
        <div class="wrap">
            <h2>
                <?php _e('Sent emails logs of ', \WPSymfonyForm::TRANSLATION_DOMAIN); ?>

                <?php echo '"' . $this->formType . '"' ?>
            </h2>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder">
                    <div id="post-body-content">
                        <?php $this->logsTable->display() ?>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <?php
    }

    /**
     * {@inheritdoc}
     */
    public function screenOptions()
    {
        add_screen_option('per_page', [
            'label'   => 'Logs',
            'default' => 10,
            'option'  => 'logs_per_page',
        ]);
    }
}
