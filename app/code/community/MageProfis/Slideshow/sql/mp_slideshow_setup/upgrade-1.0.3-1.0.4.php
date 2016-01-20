<?php
$installer = $this;
/* @var $installer MageProfis_Slideshow_Model_Resource_Setup */

$installer->startSetup();
$installer->run("
	ALTER TABLE `{$installer->getTable('mp_slideshow/slideshow')}` ADD `text_position` VARCHAR( 255 ) NULL DEFAULT 'right' AFTER `slideshow_id`
");
$installer->endSetup();