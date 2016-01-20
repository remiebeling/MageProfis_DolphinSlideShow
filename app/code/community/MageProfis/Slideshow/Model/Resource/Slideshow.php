<?php

class MageProfis_Slideshow_Model_Resource_Slideshow extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('mp_slideshow/slideshow', 'slideshow_id');
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $condition = $this->_getWriteAdapter()->quoteInto('slideshow_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('store'), $condition);

        if (!$object->getData('store_id')) {
            $storeArray = array();
            $storeArray['slideshow_id'] = $object->getId();
            $storeArray['store_id'] = '0';
            $this->_getWriteAdapter()->insert($this->getTable('store'), $storeArray);
        } else {
            foreach ((array)$object->getData('store_id') as $store) {
                $storeArray = array();
                $storeArray['slideshow_id'] = $object->getId();
                $storeArray['store_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('store'), $storeArray);
            }
        }
        return parent::_afterSave($object);
    }

    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this|Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('store'))
            ->where('slideshow_id = ?', $object->getId())
        ;

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string                   $field
     * @param mixed                    $value
     * @param Mage_Core_Model_Abstract $object
     *
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $select
                ->join(array('cps' => $this->getTable('store')), $this->getMainTable() . '.slideshow_id = `cps`.slideshow_id')
                ->where('`cps`.store_id in (0, ?) ', $object->getStoreId())
                ->order('store_id DESC')
                ->limit(1)
            ;
        }
        return $select;
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        // Cleanup stats on slideshow delete
        $adapter = $this->_getWriteAdapter();

        // 1. Delete slideshow/store
        $adapter->delete($this->getTable('mp_slideshow/store'), 'slideshow_id=' . $object->getId());
    }
}
