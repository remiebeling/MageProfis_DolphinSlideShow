<?php

class MageProfis_Slideshow_Model_Source_Groupname
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array(array(
            'value' => '',
            'label' => Mage::helper('adminhtml')->__('-- Please Select --'),
        ));
        foreach ($this->getAllOptions() as $option) {
            $options[] = array(
                'value' => $option['group_name'],
                'label' => $option['group_name'],
            );
        }

        return $options;
    }

    public function getAllOptions()
    {
        $res = Mage::getResourceModel('mp_slideshow/slideshow');

        $read = Mage::getModel('core/resource')->getConnection('core_read');
        $select = $read->select()
            ->from(array('s' => $res->getTable('slideshow')), array('group_name'))
            ->where('status = 1')
            ->group('group_name')
            ->order('group_name')
        ;

        $stmt = $read->query($select);
        $result = $stmt->fetchAll();

        $options = array();
        foreach ($result as $item) {
            $options[$item['group_name']] = $item['group_name'];
        }

        return $options;
    }
}
