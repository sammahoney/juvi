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
 * Press Article tab on product edit form
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Block_Adminhtml_Catalog_Product_Edit_Tab_Pressarticle extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('pressarticle_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        if ($this->getProduct()->getId()) {
            $this->setDefaultFilter(array('in_pressarticles'=>1));
        }
    }

    /**
     * prepare the pressarticle collection
     *
     * @access protected
     * @return Juvi_Press_Block_Adminhtml_Catalog_Product_Edit_Tab_Pressarticle
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('juvi_press/pressarticle_collection');
        if ($this->getProduct()->getId()) {
            $constraint = 'related.product_id='.$this->getProduct()->getId();
        } else {
            $constraint = 'related.product_id=0';
        }
        $collection->getSelect()->joinLeft(
            array('related' => $collection->getTable('juvi_press/pressarticle_product')),
            'related.pressarticle_id=main_table.entity_id AND '.$constraint,
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
     * @return Juvi_Press_Block_Adminhtml_Catalog_Product_Edit_Tab_Pressarticle
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
     * @return Juvi_Press_Block_Adminhtml_Catalog_Product_Edit_Tab_Pressarticle
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_pressarticles',
            array(
                'header_css_class'  => 'a-center',
                'type'  => 'checkbox',
                'name'  => 'in_pressarticles',
                'values'=> $this->_getSelectedPressarticles(),
                'align' => 'center',
                'index' => 'entity_id'
            )
        );
        $this->addColumn(
            'press_article_title',
            array(
                'header' => Mage::helper('juvi_press')->__('Press Article Title'),
                'align'  => 'left',
                'index'  => 'press_article_title',
                'renderer' => 'juvi_press/adminhtml_helper_column_renderer_relation',
                'params' => array(
                    'id' => 'getId'
                ),
                'base_link' => 'adminhtml/press_pressarticle/edit',
            )
        );
        $this->addColumn(
            'position',
            array(
                'header'         => Mage::helper('juvi_press')->__('Position'),
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
     * Retrieve selected pressarticles
     *
     * @access protected
     * @return array
     * @author Ultimate Module Creator
     */
    protected function _getSelectedPressarticles()
    {
        $pressarticles = $this->getProductPressarticles();
        if (!is_array($pressarticles)) {
            $pressarticles = array_keys($this->getSelectedPressarticles());
        }
        return $pressarticles;
    }

    /**
     * Retrieve selected pressarticles
     *
     * @access protected
     * @return array
     * @author Ultimate Module Creator
     */
    public function getSelectedPressarticles()
    {
        $pressarticles = array();
        //used helper here in order not to override the product model
        $selected = Mage::helper('juvi_press/product')->getSelectedPressarticles(Mage::registry('current_product'));
        if (!is_array($selected)) {
            $selected = array();
        }
        foreach ($selected as $pressarticle) {
            $pressarticles[$pressarticle->getId()] = array('position' => $pressarticle->getPosition());
        }
        return $pressarticles;
    }

    /**
     * get row url
     *
     * @access public
     * @param Juvi_Press_Model_Pressarticle
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
            '*/*/pressarticlesGrid',
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
     * @return Juvi_Press_Block_Adminhtml_Catalog_Product_Edit_Tab_Pressarticle
     * @author Ultimate Module Creator
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_pressarticles') {
            $pressarticleIds = $this->_getSelectedPressarticles();
            if (empty($pressarticleIds)) {
                $pressarticleIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$pressarticleIds));
            } else {
                if ($pressarticleIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$pressarticleIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}
