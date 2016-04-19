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
 * Press Article - product relation resource model collection
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Model_Resource_Pressarticle_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection
{
    /**
     * remember if fields have been joined
     *
     * @var bool
     */
    protected $_joinedFields = false;

    /**
     * join the link table
     *
     * @access public
     * @return Juvi_Press_Model_Resource_Pressarticle_Product_Collection
     * @author Ultimate Module Creator
     */
    public function joinFields()
    {
        if (!$this->_joinedFields) {
            $this->getSelect()->join(
                array('related' => $this->getTable('juvi_press/pressarticle_product')),
                'related.product_id = e.entity_id',
                array('position')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }

    /**
     * add press article filter
     *
     * @access public
     * @param Juvi_Press_Model_Pressarticle | int $pressarticle
     * @return Juvi_Press_Model_Resource_Pressarticle_Product_Collection
     * @author Ultimate Module Creator
     */
    public function addPressarticleFilter($pressarticle)
    {
        if ($pressarticle instanceof Juvi_Press_Model_Pressarticle) {
            $pressarticle = $pressarticle->getId();
        }
        if (!$this->_joinedFields ) {
            $this->joinFields();
        }
        $this->getSelect()->where('related.pressarticle_id = ?', $pressarticle);
        return $this;
    }
}
