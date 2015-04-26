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
 * Product helper
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Helper_Product extends Juvi_Gemstones_Helper_Data
{

    /**
     * get the selected gemstones for a product
     *
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return array()
     * @author Ultimate Module Creator
     */
    public function getSelectedGemstones(Mage_Catalog_Model_Product $product)
    {
        if (!$product->hasSelectedGemstones()) {
            $gemstones = array();
            foreach ($this->getSelectedGemstonesCollection($product) as $gemstone) {
                $gemstones[] = $gemstone;
            }
            $product->setSelectedGemstones($gemstones);
        }
        return $product->getData('selected_gemstones');
    }

    /**
     * get gemstone collection for a product
     *
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return Juvi_Gemstones_Model_Resource_Gemstone_Collection
     * @author Ultimate Module Creator
     */
    public function getSelectedGemstonesCollection(Mage_Catalog_Model_Product $product)
    {
        $collection = Mage::getResourceSingleton('juvi_gemstones/gemstone_collection')
            ->addProductFilter($product);
        return $collection;
    }
}
