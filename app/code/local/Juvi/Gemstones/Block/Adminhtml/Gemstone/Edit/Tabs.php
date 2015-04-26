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
 * Gemstone admin edit tabs
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Adminhtml_Gemstone_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('gemstone_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('juvi_gemstones')->__('Gemstone'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Gemstone_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_gemstone',
            array(
                'label'   => Mage::helper('juvi_gemstones')->__('Gemstone'),
                'title'   => Mage::helper('juvi_gemstones')->__('Gemstone'),
                'content' => $this->getLayout()->createBlock(
                    'juvi_gemstones/adminhtml_gemstone_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'form_meta_gemstone',
            array(
                'label'   => Mage::helper('juvi_gemstones')->__('Meta'),
                'title'   => Mage::helper('juvi_gemstones')->__('Meta'),
                'content' => $this->getLayout()->createBlock(
                    'juvi_gemstones/adminhtml_gemstone_edit_tab_meta'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'products',
            array(
                'label' => Mage::helper('juvi_gemstones')->__('Associated products'),
                'url'   => $this->getUrl('*/*/products', array('_current' => true)),
                'class' => 'ajax'
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve gemstone entity
     *
     * @access public
     * @return Juvi_Gemstones_Model_Gemstone
     * @author Ultimate Module Creator
     */
    public function getGemstone()
    {
        return Mage::registry('current_gemstone');
    }
}
