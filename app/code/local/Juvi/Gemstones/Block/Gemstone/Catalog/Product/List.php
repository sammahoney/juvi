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
 * Gemstone product list
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Gemstone_Catalog_Product_List extends Mage_Core_Block_Template
{
    /**
     * get the list of products
     *
     * @access public
     * @return Mage_Catalog_Model_Resource_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getProductCollection()
    {
        $collection = $this->getGemstone()->getSelectedProductsCollection();
        $collection->addAttributeToSelect('name');
        $collection->addUrlRewrite();
        $collection->getSelect()->order('related.position');
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
        return $collection;
    }

    /**
     * get current gemstone
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
