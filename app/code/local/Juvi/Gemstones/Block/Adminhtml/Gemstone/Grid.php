<?php
/**
 * Juvi_Gemstones extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Juvi
 * @package        Juvi_Gemstones
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Gemstone admin grid block
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Adminhtml_Gemstone_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('gemstoneGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Gemstone_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('juvi_gemstones/gemstone')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Gemstone_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('juvi_gemstones')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'stone_name',
            array(
                'header'    => Mage::helper('juvi_gemstones')->__('Stone Name'),
                'align'     => 'left',
                'index'     => 'stone_name',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('juvi_gemstones')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('juvi_gemstones')->__('Enabled'),
                    '0' => Mage::helper('juvi_gemstones')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'stone_origin',
            array(
                'header' => Mage::helper('juvi_gemstones')->__('Stone Origin'),
                'index'  => 'stone_origin',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'url_key',
            array(
                'header' => Mage::helper('juvi_gemstones')->__('URL key'),
                'index'  => 'url_key',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('juvi_gemstones')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('juvi_gemstones')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('juvi_gemstones')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('juvi_gemstones')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('juvi_gemstones')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Gemstone_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('gemstone');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('juvi_gemstones')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('juvi_gemstones')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('juvi_gemstones')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('juvi_gemstones')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('juvi_gemstones')->__('Enabled'),
                            '0' => Mage::helper('juvi_gemstones')->__('Disabled'),
                        )
                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Juvi_Gemstones_Model_Gemstone
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Gemstone_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
