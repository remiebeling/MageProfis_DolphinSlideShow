<?php

class Dolphin_Slideshow_Model_Mysql4_Slideshow_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('slideshow/slideshow');
    }

    /**
     * Add Filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     *
     * @return Mage_Cms_Model_Mysql4_Page_Collection
     */
    public function addStoreFilter($store = null, $withAdmin = true)
    {
        if ($store === null) {
            $store = array(Mage::app()->getStore()->getId());
        }
        if (!Mage::app()->isSingleStoreMode()) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            if (!is_array($store)) {
                $store = array($store);
            }

            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }

            $this->getSelect()
                ->joinLeft(
                    array('store_table' => $this->getTable('store')),
                    'main_table.slideshow_id = store_table.slideshow_id',
                    array()
                )
                ->where('store_table.store_id in (?)', $store)
            ;
        }
        return $this;
    }
}
