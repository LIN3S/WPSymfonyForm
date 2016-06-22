<?php

namespace LIN3S\WPSymfonyForm\Admin\Views;

use LIN3S\WPSymfonyForm\Admin\Views\Components\FormsTable;

/**
 * General page.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class General implements Page
{
    /**
     * The forms table component.
     *
     * @var FormsTable
     */
    private $formsTable;

    /**
     * Constructor.
     *
     * @param FormsTable $formsTable The logs table component
     */
    public function __construct(FormsTable $formsTable)
    {
        $this->formsTable = $formsTable;
    }

    /**
     * {@inheritdoc}
     */
    public function display()
    {
        $this->formsTable->prepare_items();

        ?>
        <div class="wrap">
            <h2><?php _e('General', \WPSymfonyForm::TRANSLATION_DOMAIN); ?></h2>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder">
                    <div id="post-body-content">
                        <?php $this->formsTable->display(); ?>
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
            'label'   => 'Forms',
            'default' => 10,
            'option'  => 'forms_per_page',
        ]);
    }
}
