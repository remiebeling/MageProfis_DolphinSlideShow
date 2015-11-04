<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('slideshow/store')} (
    `slideshow_id` int(11) unsigned,
    `store_id` smallint(5) unsigned
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

");

$coll = Mage::getModel('slideshow/slideshow')->getCollection();

foreach ($coll as $item) {
    $stores = explode(',', $item->getStores());
    foreach ($stores as $store_id) {
        $installer->run("INSERT INTO `{$this->getTable('slideshow/store')}` VALUES ({$item->getSlideshowId()}, {$store_id});");
    }
}

$installer->run("ALTER TABLE `{$installer->getTable('slideshow')}` DROP `stores`;");

$installer->endSetup();