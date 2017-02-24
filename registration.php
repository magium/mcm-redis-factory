<?php

$instance = \Magium\Configuration\File\Configuration\ConfigurationFileRepository::getInstance();

$instance->addSecureBase(realpath(__DIR__ . DIRECTORY_SEPARATOR . 'etc'));
$instance->registerConfigurationFile(
    new \Magium\Configuration\File\Configuration\XmlFile(
        realpath(__DIR__ . '/etc/settings.xml')
    )
);
