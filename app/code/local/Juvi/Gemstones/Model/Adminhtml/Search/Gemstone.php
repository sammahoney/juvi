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
 * Admin search model
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Model_Adminhtml_Search_Gemstone extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Juvi_Gemstones_Model_Adminhtml_Search_Gemstone
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('juvi_gemstones/gemstone_collection')
            ->addFieldToFilter('stone_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $gemstone) {
            $arr[] = array(
                'id'          => 'gemstone/1/'.$gemstone->getId(),
                'type'        => Mage::helper('juvi_gemstones')->__('Gemstone'),
                'name'        => $gemstone->getStoneName(),
                'description' => $gemstone->getStoneName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/gemstones_gemstone/edit',
                    array('id'=>$gemstone->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
