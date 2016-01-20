<?php
$installer = $this;
/* @var $installer MageProfis_Slideshow_Model_Resource_Setup */

$installer->startSetup();
$installer->run("
	ALTER TABLE `{$installer->getTable('mp_slideshow/slideshow')}` ADD `stores` VARCHAR( 255 ) NOT NULL DEFAULT '0' AFTER `slideshow_id`
");
$installer->endSetup();