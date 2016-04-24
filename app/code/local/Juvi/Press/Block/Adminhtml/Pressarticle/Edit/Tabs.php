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
 * Press Article admin edit tabs
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Block_Adminhtml_Pressarticle_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('pressarticle_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('juvi_press')->__('Press Article'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Juvi_Press_Block_Adminhtml_Pressarticle_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_pressarticle',
            array(
                'label'   => Mage::helper('juvi_press')->__('Press Article'),
                'title'   => Mage::helper('juvi_press')->__('Press Article'),
                'content' => $this->getLayout()->createBlock(
                    'juvi_press/adminhtml_pressarticle_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'form_meta_pressarticle',
            array(
                'label'   => Mage::helper('juvi_press')->__('Meta'),
                'title'   => Mage::helper('juvi_press')->__('Meta'),
                'content' => $this->getLayout()->createBlock(
                    'juvi_press/adminhtml_pressarticle_edit_tab_meta'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'products',
            array(
                'label' => Mage::helper('juvi_press')->__('Associated products'),
                'url'   => $this->getUrl('*/*/products', array('_current' => true)),
                'class' => 'ajax'
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve press article entity
     *
     * @access public
     * @return Juvi_Press_Model_Pressarticle
     * @author Ultimate Module Creator
     */
    public function getPressarticle()
    {
        return Mage::registry('current_pressarticle');
    }
}
