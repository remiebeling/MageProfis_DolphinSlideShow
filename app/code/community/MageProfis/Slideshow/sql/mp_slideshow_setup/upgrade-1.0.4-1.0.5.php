<?php

$installer = $this;
/* @var $installer MageProfis_Slideshow_Model_Resource_Setup */

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('mp_slideshow/store')} (
    `slideshow_id` int(11) unsigned,
    `store_id` smallint(5) unsigned
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

");

$coll = Mage::getModel('mp_slideshow/slideshow')->getCollection();

foreach ($coll as $item) {
    $stores = explode(',', $item->getStores());
    foreach ($stores as $store_id) {
        $installer->run("INSERT INTO `{$this->getTable('mp_slideshow/store')}` VALUES ({$item->getSlideshowId()}, {$store_id});");
    }
}

$installer->run("ALTER TABLE `{$installer->getTable('mp_slideshow/slideshow')}` DROP `stores`;");

$installer->endSetup();