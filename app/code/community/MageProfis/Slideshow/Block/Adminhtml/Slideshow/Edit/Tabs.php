<?php

class MageProfis_Slideshow_Block_Adminhtml_Slideshow_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('slideshow_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('mp_slideshow')->__('Slide Item'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('mp_slideshow')->__('General'),
            'title'     => Mage::helper('mp_slideshow')->__('General'),
            'content'   => $this->getLayout()->createBlock('mp_slideshow/adminhtml_slideshow_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
