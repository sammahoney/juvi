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
 * Product helper
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Helper_Product extends Juvi_Press_Helper_Data
{

    /**
     * get the selected press articles for a product
     *
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return array()
     * @author Ultimate Module Creator
     */
    public function getSelectedPressarticles(Mage_Catalog_Model_Product $product)
    {
        if (!$product->hasSelectedPressarticles()) {
            $pressarticles = array();
            foreach ($this->getSelectedPressarticlesCollection($product) as $pressarticle) {
                $pressarticles[] = $pressarticle;
            }
            $product->setSelectedPressarticles($pressarticles);
        }
        return $product->getData('selected_pressarticles');
    }

    /**
     * get press article collection for a product
     *
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return Juvi_Press_Model_Resource_Pressarticle_Collection
     * @author Ultimate Module Creator
     */
    public function getSelectedPressarticlesCollection(Mage_Catalog_Model_Product $product)
    {
        $collection = Mage::getResourceSingleton('juvi_press/pressarticle_collection')
            ->addProductFilter($product);
        return $collection;
    }
}
