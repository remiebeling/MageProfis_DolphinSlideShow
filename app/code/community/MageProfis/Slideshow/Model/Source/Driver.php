<?php

class MageProfis_Slideshow_Model_Source_Driver
{
    const MP_SLIDESHOW_DRIVER_OWL   = 'owl';
    const MP_SLIDESHOW_DRIVER_SLICK = 'slick';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $values = $this->toArray();
        $options = array();
        foreach ($values as $value => $label) {
            $options[] = array(
                'value' => $value,
                'label' => $label,
            );
        }

        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'owl'   => Mage::helper('mp_slideshow')->__('Owl Slider'),
            'slick' => Mage::helper('mp_slideshow')->__('Slick Slider'),
        );
    }
}