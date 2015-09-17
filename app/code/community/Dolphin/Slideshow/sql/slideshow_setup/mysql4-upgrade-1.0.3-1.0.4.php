<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();
$installer->run("
	ALTER TABLE `{$installer->getTable('slideshow')}` ADD `text_position` VARCHAR( 255 ) NULL DEFAULT 'right' AFTER `slideshow_id`
");
$installer->endSetup();