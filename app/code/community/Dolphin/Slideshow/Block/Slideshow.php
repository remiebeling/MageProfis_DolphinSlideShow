<?php

class Dolphin_Slideshow_Block_Slideshow extends Mage_Catalog_Block_Product_View_Media
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getProduct($sku)
    {
        $item = Mage::getModel('catalog/product')->getCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('sku', $sku)
                    ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                    ->addMinimalPrice()
                    ->addFinalPrice()
                    ->addTaxPercents()
                    ->addUrlRewrite(0)
                    ->setPageSize(1)
                    ->setCurPage(1)
                    ->getFirstItem();
        return $item;
    }

    public function getSpecialPrice($_product)
    {
        if(!$_product->hasSpecialPrice() && !$_product->isGrouped())
        {
            return false;
        }
        elseif($_product->isGrouped())
        {
            $special_price = null;
            $regular_price = null;
            foreach($_product->getTypeInstance(true)->getAssociatedProducts($_product) as $_chilproduct)
            {
                if(!$_chilproduct->hasSpecialPrice())
                {
                    continue;
                }

                $specialPriceFromDate = $_chilproduct->getSpecialFromDate();
                $specialPriceToDate = $_chilproduct->getSpecialToDate();
                $today = time();
                if($today >= strtotime($specialPriceFromDate) && $today <= strtotime($specialPriceToDate) || $today >= strtotime( $specialPriceFromDate) && is_null($specialPriceToDate))
                {
                    if(is_null($special_price) || $special_price > $_chilproduct->getFinalPrice())
                    {
                        $special_price = $_chilproduct->getSpecialPrice();
                    }
                }
            }
            return $special_price;
        }
        else {
            $specialPriceFromDate = $_product->getSpecialFromDate();
            $specialPriceToDate = $_product->getSpecialToDate();
            $today = time();
            if($today >= strtotime($specialPriceFromDate) && $today <= strtotime($specialPriceToDate) || $today >= strtotime( $specialPriceFromDate) && is_null($specialPriceToDate))
            {
                return $_product->getSpecialPrice();
            }
        }
        return false;
    }

    public function getRegularPrice($_product)
    {
        if(!$_product->isGrouped())
        {
            $regular_price = $_product->getPrice();
        }
        else
        {
            $regular_price = null;
            foreach($_product->getTypeInstance(true)->getAssociatedProducts($_product) as $_chilproduct)
            {
                if(is_null($regular_price) || $regular_price > $_chilproduct->getPrice())
                {
                    $regular_price = $_chilproduct->getPrice();
                }
            }
        }
        return $regular_price;
    }
}
