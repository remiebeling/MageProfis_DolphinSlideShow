<?php

class MageProfis_Slideshow_Block_Widget_Slideshow
extends Mage_Core_Block_Template
implements Mage_Widget_Block_Interface
{
    protected $_template = 'mp_slideshow/widget/default.phtml';

    /**
     * Get slides for this widget, filtered by group_name
     *
     * @return MageProfis_Slideshow_Model_Resource_Slideshow_Collection|array
     */
    public function getSlides()
    {
        if ($this->getData('group_name') != '') {
            $slides = Mage::getModel('mp_slideshow/slideshow')->getCollection()
                ->addStoreFilter()
                ->addFieldToFilter('group_name', $this->getData('group_name'))
                ->addFieldToFilter('filename', array('neq' => ''))
                ->addFieldToFilter('status', array('eq' => '1'))
                ->setOrder('sort_order', 'ASC')
            ;

            return $slides;
        }

        return array();
    }
}