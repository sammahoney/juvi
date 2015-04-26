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
 * Adminhtml observer
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Model_Adminhtml_Observer
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
     * add the gemstone tab to products
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Juvi_Gemstones_Model_Adminhtml_Observer
     * @author Ultimate Module Creator
     */
    public function addProductGemstoneBlock($observer)
    {
        $block = $observer->getEvent()->getBlock();
        $product = Mage::registry('product');
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)) {
            $block->addTab(
                'gemstones',
                array(
                    'label' => Mage::helper('juvi_gemstones')->__('Gemstones'),
                    'url'   => Mage::helper('adminhtml')->getUrl(
                        'adminhtml/gemstones_gemstone_catalog_product/gemstones',
                        array('_current' => true)
                    ),
                    'class' => 'ajax',
                )
            );
        }
        return $this;
    }

    /**
     * save gemstone - product relation
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Juvi_Gemstones_Model_Adminhtml_Observer
     * @author Ultimate Module Creator
     */
    public function saveProductGemstoneData($observer)
    {
        $post = Mage::app()->getRequest()->getPost('gemstones', -1);
        if ($post != '-1') {
            $post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
            $product = Mage::registry('product');
            $gemstoneProduct = Mage::getResourceSingleton('juvi_gemstones/gemstone_product')
                ->saveProductRelation($product, $post);
        }
        return $this;
    }}
