<?php

/*
 * This file is part of the WPSymfonyForm plugin.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPSymfonyForm\Action;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Local storage action.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class LocalStorageAction implements Action
{
    /**
     * The dir path of YAML file.
     *
     * @var string
     */
    private $yamlFile;

    /**
     * Constructor.
     *
     * @param string|null $yamlFile The dir path of YAML file
     */
    public function __construct($yamlFile = null)
    {
        $this->yamlFile = __DIR__ . '/../../../../../../../wp_symfony_form_email_log.yml';
        if (null !== $yamlFile) {
            $this->yamlFile = $yamlFile;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute(FormInterface $form)
    {
        $existentData = Yaml::parse(file_get_contents($this->yamlFile));
        $newData = ['date' => (new \DateTimeImmutable())->format('Y-m-d - h:m')];
        $newData = array_merge($newData, $form->getData());

        $data = null !== $existentData ? array_merge($existentData, [$newData]) : [$newData];

        file_put_contents($this->yamlFile, Yaml::dump($data));
    }
}
