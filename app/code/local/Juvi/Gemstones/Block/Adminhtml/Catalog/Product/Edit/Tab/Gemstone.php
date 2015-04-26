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
 * Gemstone tab on product edit form
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Adminhtml_Catalog_Product_Edit_Tab_Gemstone extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set grid params
     *
     * @access public
     * @author Ultimate Module Creator
     */

    public function __construct()
    {
        parent::__construct();
        $this->setId('gemstone_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        if ($this->getProduct()->getId()) {
            $this->setDefaultFilter(array('in_gemstones'=>1));
        }
    }

    /**
     * prepare the gemstone collection
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Catalog_Product_Edit_Tab_Gemstone
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('juvi_gemstones/gemstone_collection');
        if ($this->getProduct()->getId()) {
            $constraint = 'related.product_id='.$this->getProduct()->getId();
        } else {
            $constraint = 'related.product_id=0';
        }
        $collection->getSelect()->joinLeft(
            array('related' => $collection->getTable('juvi_gemstones/gemstone_product')),
            'related.gemstone_id=main_table.entity_id AND '.$constraint,
            array('position')
        );
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    /**
     * prepare mass action grid
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Catalog_Product_Edit_Tab_Gemstone
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        return $this;
    }

    /**
     * prepare the grid columns
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Catalog_Product_Edit_Tab_Gemstone
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_gemstones',
            array(
                'header_css_class'  => 'a-center',
                'type'  => 'checkbox',
                'name'  => 'in_gemstones',
                'values'=> $this->_getSelectedGemstones(),
                'align' => 'center',
                'index' => 'entity_id'
            )
        );
        $this->addColumn(
            'stone_name',
            array(
                'header' => Mage::helper('juvi_gemstones')->__('Stone Name'),
                'align'  => 'left',
                'index'  => 'stone_name',
                'renderer' => 'juvi_gemstones/adminhtml_helper_column_renderer_relation',
                'params' => array(
                    'id' => 'getId'
                ),
                'base_link' => 'adminhtml/gemstones_gemstone/edit',
            )
        );
        $this->addColumn(
            'position',
            array(
                'header'         => Mage::helper('juvi_gemstones')->__('Position'),
                'name'           => 'position',
                'width'          => 60,
                'type'           => 'number',
                'validate_class' => 'validate-number',
                'index'          => 'position',
                'editable'       => true,
            )
        );
        return parent::_prepareColumns();
    }

    /**
     * Retrieve selected gemstones
     *
     * @access protected
     * @return array
     * @author Ultimate Module Creator
     */
    protected function _getSelectedGemstones()
    {
        $gemstones = $this->getProductGemstones();
        if (!is_array($gemstones)) {
            $gemstones = array_keys($this->getSelectedGemstones());
        }
        return $gemstones;
    }

    /**
     * Retrieve selected gemstones
     *
     * @access protected
     * @return array
     * @author Ultimate Module Creator
     */
    public function getSelectedGemstones()
    {
        $gemstones = array();
        //used helper here in order not to override the product model
        $selected = Mage::helper('juvi_gemstones/product')->getSelectedGemstones(Mage::registry('current_product'));
        if (!is_array($selected)) {
            $selected = array();
        }
        foreach ($selected as $gemstone) {
            $gemstones[$gemstone->getId()] = array('position' => $gemstone->getPosition());
        }
        return $gemstones;
    }

    /**
     * get row url
     *
     * @access public
     * @param Juvi_Gemstones_Model_Gemstone
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($item)
    {
        return '#';
    }

    /**
     * get grid url
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl()
    {
        return $this->getUrl(
            '*/*/gemstonesGrid',
            array(
                'id'=>$this->getProduct()->getId()
            )
        );
    }

    /**
     * get the current product
     *
     * @access public
     * @return Mage_Catalog_Model_Product
     * @author Ultimate Module Creator
     */
    public function getProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Add filter
     *
     * @access protected
     * @param object $column
     * @return Juvi_Gemstones_Block_Adminhtml_Catalog_Product_Edit_Tab_Gemstone
     * @author Ultimate Module Creator
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_gemstones') {
            $gemstoneIds = $this->_getSelectedGemstones();
            if (empty($gemstoneIds)) {
                $gemstoneIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$gemstoneIds));
            } else {
                if ($gemstoneIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$gemstoneIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}
