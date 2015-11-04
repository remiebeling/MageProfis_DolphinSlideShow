<?php

class Dolphin_Slideshow_Block_Adminhtml_Slideshow_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('slideshowGrid');
        // This is the primary key of the database
        $this->setDefaultSort('slideshow_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _getStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('slideshow/slideshow')->getCollection();
        $store = $this->_getStore();
        if ($store->getId()) {
            $collection->addStoreFilter($store);
        }
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('slideshow_id', array(
            'header'    => Mage::helper('slideshow')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'slideshow_id',
        ));

        $this->addColumn('filename', array(
            'header' => Mage::helper('slideshow')->__('Slide Image'),
            'align' => 'left',
            'index' => 'filename',
            'renderer' => 'slideshow/adminhtml_grid_renderer_image',
            'width'    => '130px',
            'align'    => 'center',
            'escape'    => true,
            'sortable'  => false,
            'filter'    => false,
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('slideshow')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
            'sortable'  => true,
        ));

        $this->addColumn('slide_url', array(
            'header'    => Mage::helper('slideshow')->__('URL'),
            'align'     => 'left',
            'index'     => 'slide_url',
            'sortable'  => true,
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('slideshow')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('sort_order', array(
            'header'    => Mage::helper('slideshow')->__('Sort Order'),
            'align'     =>'left',
            'index'     => 'sort_order',
            'sortable'  => true,
        ));

        $this->addColumn('status', array(

            'header'    => Mage::helper('slideshow')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }
}
