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
 * Adminhtml observer
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Model_Adminhtml_Observer
{
    /**
     * check if tab can be added
     *
     * @access protected
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     * @author Ultimate Module Creator
     */
    protected function _canAddTab($product)
    {
        if ($product->getId()) {
            return true;
        }
        if (!$product->getAttributeSetId()) {
            return false;
        }
        $request = Mage::app()->getRequest();
        if ($request->getParam('type') == 'configurable') {
            if ($request->getParam('attributes')) {
                return true;
            }
        }
        return false;
    }

    /**
     * add the press article tab to products
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Juvi_Press_Model_Adminhtml_Observer
     * @author Ultimate Module Creator
     */
    public function addProductPressarticleBlock($observer)
    {
        $block = $observer->getEvent()->getBlock();
        $product = Mage::registry('product');
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)) {
            $block->addTab(
                'pressarticles',
                array(
                    'label' => Mage::helper('juvi_press')->__('Press Articles'),
                    'url'   => Mage::helper('adminhtml')->getUrl(
                        'adminhtml/press_pressarticle_catalog_product/pressarticles',
                        array('_current' => true)
                    ),
                    'class' => 'ajax',
                )
            );
        }
        return $this;
    }

    /**
     * save press article - product relation
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Juvi_Press_Model_Adminhtml_Observer
     * @author Ultimate Module Creator
     */
    public function saveProductPressarticleData($observer)
    {
        $post = Mage::app()->getRequest()->getPost('pressarticles', -1);
        if ($post != '-1') {
            $post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
            $product = Mage::registry('product');
            $pressarticleProduct = Mage::getResourceSingleton('juvi_press/pressarticle_product')
                ->saveProductRelation($product, $post);
        }
        return $this;
    }}
