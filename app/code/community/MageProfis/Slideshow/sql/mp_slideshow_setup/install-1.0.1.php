<?php

$installer = $this;
/* @var $installer MageProfis_Slideshow_Model_Resource_Setup */

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('mp_slideshow/slideshow')};
CREATE TABLE {$this->getTable('mp_slideshow/slideshow')} (
  `slideshow_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `slide_url` varchar(500) NOT NULL default '',
  `slide_target` varchar(255) NOT NULL default '',
  `product` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`slideshow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();
