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
 * Gemstone - product relation resource model collection
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Model_Resource_Gemstone_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection
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
     * @return Juvi_Gemstones_Model_Resource_Gemstone_Product_Collection
     * @author Ultimate Module Creator
     */
    public function joinFields()
    {
        if (!$this->_joinedFields) {
            $this->getSelect()->join(
                array('related' => $this->getTable('juvi_gemstones/gemstone_product')),
                'related.product_id = e.entity_id',
                array('position')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }

    /**
     * add gemstone filter
     *
     * @access public
     * @param Juvi_Gemstones_Model_Gemstone | int $gemstone
     * @return Juvi_Gemstones_Model_Resource_Gemstone_Product_Collection
     * @author Ultimate Module Creator
     */
    public function addGemstoneFilter($gemstone)
    {
        if ($gemstone instanceof Juvi_Gemstones_Model_Gemstone) {
            $gemstone = $gemstone->getId();
        }
        if (!$this->_joinedFields ) {
            $this->joinFields();
        }
        $this->getSelect()->where('related.gemstone_id = ?', $gemstone);
        return $this;
    }
}
