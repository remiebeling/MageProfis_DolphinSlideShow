<?php

$installer = $this;
/* @var $installer MageProfis_Slideshow_Model_Resource_Setup */

$installer->startSetup();

$connection = $installer->getConnection();
/* @var $connection Varien_Db_Adapter_Interface */

$connection->addColumn($installer->getTable('mp_slideshow/slideshow'), 'active_from', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_DATETIME,
    'nullable' => true,
    'default'  => null,
    'comment'  => 'Active From',
    'after'    => 'status',
));

$connection->addColumn($installer->getTable('mp_slideshow/slideshow'), 'active_to', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_DATETIME,
    'nullable' => true,
    'default'  => null,
    'comment'  => 'Active To',
    'after'    => 'active_from',
));

$installer->endSetup();