<?php

class MageProfis_Slideshow_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_SLIDER_DRIVER = 'mp_slideshow/general/driver';

    /**
     *
     * @return stringGet currently selected driver (slideshow js framework)
     *
     * @return string Driver name
     */
    public function getDriver()
    {
        return Mage::getStoreConfig(self::XML_PATH_SLIDER_DRIVER);
    }

    public function getSlidesPath()
    {
        return 'slideshow' . '/' . 'slides' . '/';
    }

    public function getThumbsPath($slidesPath)
    {
        return str_replace('/slides/', '/slides/thumbs/', $slidesPath);
    }

    public function resizeImg($fileName, $width, $height = '')
    {
        //$fileName = 'slideshow\slides\\'.$fileName;

        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageURL = $folderURL . $fileName;

        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'slideshow'. DS . 'slides' . DS . $fileName;

        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'slideshow' . DS . 'slides' . DS . 'thumbs' . DS . $fileName;
        //if width empty then return original size image's URL
        if ($width != '') {
            //if image has already resized then just return URL
            if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {

                $imageObj = new Varien_Image($basePath);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(FALSE);
                $imageObj->keepFrame(FALSE);
                $imageObj->resize($width, $height);
                $imageObj->save($newPath);

            }
            $resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'resized' . DS . $fileName;
         } else {
            $resizedURL = $imageURL;
         }
         return $resizedURL;
    }

    /**
     * Append JS and CSS files to head block
     *
     * @param Mage_Page_Block_Html_Head
     */
    public function appendAssetsToHeadBlock($headBlock)
    {
        return;
        if ($headBlock && $headBlock instanceof Mage_Page_Block_Html_Head) {
            if ($this->getSliderCssFile()) {
                $headBlock->addCss($this->getSliderCssFile());
            }
            if ($this->getSliderCssThemeFile()) {
                $headBlock->addCss($this->getSliderCssThemeFile());
            }
            if ($this->getSliderCssTransitionFile()) {
                $headBlock->addCss($this->getSliderCssTransitionFile());
            }
            if ($this->getSliderJsFile()) {
                $headBlock->addItem('skin_js', $this->getSliderJsFile());
            }
        }
    }

    /**
     * Get slider JS file
     *
     * @return string JS file
     */
    public function getSliderJsFile()
    {
        $driver = Mage::helper('mp_slideshow')->getDriver();

        if (MageProfis_Slideshow_Model_Source_Driver::MP_SLIDESHOW_DRIVER_SLICK == $driver) {
            return 'js/mp_slideshow/slick/slick.min.js';
        }

        return 'js/mp_slideshow/owl/owl.carousel.min.js';
    }

    /**
     * Get slider main CSS file
     *
     * @return string CSS main file
     */
    public function getSliderCssFile()
    {
        $driver = Mage::helper('mp_slideshow')->getDriver();

        if (MageProfis_Slideshow_Model_Source_Driver::MP_SLIDESHOW_DRIVER_SLICK == $driver) {
            return 'css/mp_slideshow/slick/slick.css';
        }

        return 'css/mp_slideshow/owl/owl.carousel.css';
    }

    /**
     * Get slider theme CSS file
     *
     * @return string CSS theme file
     */
    public function getSliderCssThemeFile()
    {
        $driver = Mage::helper('mp_slideshow')->getDriver();

        if (MageProfis_Slideshow_Model_Source_Driver::MP_SLIDESHOW_DRIVER_SLICK == $driver) {
            return 'css/mp_slideshow/slick/slick-theme.css';
        }

        return 'css/mp_slideshow/owl/owl.theme.css';
    }

    /**
     * Get slider transition CSS file
     *
     * @return string CSS transition file
     */
    public function getSliderCssTransitionFile()
    {
        $driver = Mage::helper('mp_slideshow')->getDriver();

        if (MageProfis_Slideshow_Model_Source_Driver::MP_SLIDESHOW_DRIVER_SLICK == $driver) {
            return '';
        }

        return 'css/mp_slideshow/owl/owl.transitions.css';
    }

    /**
     * Get slider init JS file
     *
     * @return string JS init file
     */
    public function getJsInitFile()
    {
        $driver = Mage::helper('mp_slideshow')->getDriver();

        if (MageProfis_Slideshow_Model_Source_Driver::MP_SLIDESHOW_DRIVER_SLICK == $driver) {
            return Mage::getDesign()->getSkinUrl('js/mp_slideshow/slick/init.js');
        }

        return Mage::getDesign()->getSkinUrl('js/mp_slideshow/owl/init.js');
    }

    /**
     * Check if a string contains valid JSON data
     *
     * @param string $string Test string
     *
     * @return boolean
     */
    public function isValidJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
