<?php
/**
 * Juvi_Press extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Juvi
 * @package        Juvi_Press
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Press Article admin grid block
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Block_Adminhtml_Pressarticle_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('pressarticleGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Juvi_Press_Block_Adminhtml_Pressarticle_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('juvi_press/pressarticle')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Juvi_Press_Block_Adminhtml_Pressarticle_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('juvi_press')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'press_article_title',
            array(
                'header'    => Mage::helper('juvi_press')->__('Press Article Title'),
                'align'     => 'left',
                'index'     => 'press_article_title',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('juvi_press')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('juvi_press')->__('Enabled'),
                    '0' => Mage::helper('juvi_press')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'press_article_origin_date',
            array(
                'header' => Mage::helper('juvi_press')->__('Press Article Origin / Date'),
                'index'  => 'press_article_origin_date',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'url_key',
            array(
                'header' => Mage::helper('juvi_press')->__('URL key'),
                'index'  => 'url_key',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('juvi_press')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('juvi_press')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('juvi_press')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('juvi_press')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('juvi_press')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Juvi_Press_Block_Adminhtml_Pressarticle_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('pressarticle');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('juvi_press')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('juvi_press')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('juvi_press')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('juvi_press')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('juvi_press')->__('Enabled'),
                            '0' => Mage::helper('juvi_press')->__('Disabled'),
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
     * @param Juvi_Press_Model_Pressarticle
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
     * @return Juvi_Press_Block_Adminhtml_Pressarticle_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
