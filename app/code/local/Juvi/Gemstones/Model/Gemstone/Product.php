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
 * Gemstone product model
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Model_Gemstone_Product extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource
     *
     * @access protected
     * @return void
     * @author Ultimate Module Creator
     */
    protected function _construct()
    {
        $this->_init('juvi_gemstones/gemstone_product');
    }

    /**
     * Save data for gemstone-product relation
     * @access public
     * @param  Juvi_Gemstones_Model_Gemstone $gemstone
     * @return Juvi_Gemstones_Model_Gemstone_Product
     * @author Ultimate Module Creator
     */
    public function saveGemstoneRelation($gemstone)
    {
        $data = $gemstone->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveGemstoneRelation($gemstone, $data);
        }
        return $this;
    }

    /**
     * get products for gemstone
     *
     * @access public
     * @param Juvi_Gemstones_Model_Gemstone $gemstone
     * @return Juvi_Gemstones_Model_Resource_Gemstone_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getProductCollection($gemstone)
    {
        $collection = Mage::getResourceModel('juvi_gemstones/gemstone_product_collection')
            ->addGemstoneFilter($gemstone);
        return $collection;
    }
}
