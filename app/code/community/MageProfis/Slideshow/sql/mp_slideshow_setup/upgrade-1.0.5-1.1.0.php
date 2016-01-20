<?php

$installer = $this;
/* @var $installer MageProfis_Slideshow_Model_Resource_Setup */

$installer->startSetup();

$connection = $installer->getConnection();
/* @var $connection Varien_Db_Adapter_Interface */

$connection->addColumn($installer->getTable('mp_slideshow/slideshow'), 'group_name', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length'   => 255,
    'nullable' => true,
    'default'  => null,
    'comment'  => 'Group Name',
    'after'    => 'title',
));

$installer->endSetup();