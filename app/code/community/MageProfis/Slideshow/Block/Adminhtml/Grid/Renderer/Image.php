<?php

class MageProfis_Slideshow_Block_Adminhtml_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if ($row->getData($this->getColumn()->getIndex()) == "") {
            return "";
        } else {
            $imageFile = basename($row->getData($this->getColumn()->getIndex()));
            Mage::helper('mp_slideshow')->resizeImg($imageFile, 120, 60);

            $html = '<img ';
            $html .= 'id="' . $this->getColumn()->getId() . '" ';
            $html .= 'width="120" ';
            $html .= 'src="' . Mage::getBaseUrl("media") . Mage::helper('mp_slideshow')->getThumbsPath($row->getData($this->getColumn()->getIndex())) . '"';
            $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';

            return $html;
        }
    }
}
