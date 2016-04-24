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
 * Press Article product model
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Model_Pressarticle_Product extends Mage_Core_Model_Abstract
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
        $this->_init('juvi_press/pressarticle_product');
    }

    /**
     * Save data for press article-product relation
     * @access public
     * @param  Juvi_Press_Model_Pressarticle $pressarticle
     * @return Juvi_Press_Model_Pressarticle_Product
     * @author Ultimate Module Creator
     */
    public function savePressarticleRelation($pressarticle)
    {
        $data = $pressarticle->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->savePressarticleRelation($pressarticle, $data);
        }
        return $this;
    }

    /**
     * get products for press article
     *
     * @access public
     * @param Juvi_Press_Model_Pressarticle $pressarticle
     * @return Juvi_Press_Model_Resource_Pressarticle_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getProductCollection($pressarticle)
    {
        $collection = Mage::getResourceModel('juvi_press/pressarticle_product_collection')
            ->addPressarticleFilter($pressarticle);
        return $collection;
    }
}
