<?php
class MageProfis_Slideshow_Block_Adminhtml_Slideshow extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_slideshow_slideshow';
        $this->_blockGroup = 'slideshow';
        $this->_headerText = Mage::helper('mp_slideshow')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('mp_slideshow')->__('Add Item');
        parent::__construct();
    }
}
