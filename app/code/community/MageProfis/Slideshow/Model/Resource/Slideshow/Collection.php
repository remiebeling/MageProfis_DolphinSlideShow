<?php

class MageProfis_Slideshow_Model_Resource_Slideshow_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mp_slideshow/slideshow');
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
    
    public function addActiveFromToFilter()
    {
        $this->addFieldToFilter(
            'active_from',
            array(
                array('lteq' => Mage::getModel('core/date')->date()),
                array('active_from', 'null'=>'')
            )
        );
        
        $this->addFieldToFilter(
            'active_to',
            array(
                array('gteq' => Mage::getModel('core/date')->date()),
                array('active_to', 'null'=>'')
            )
        );
        
        return $this;
    }
}
