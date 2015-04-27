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
 * Gemstone list block
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Gemstone_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $gemstones = Mage::getResourceModel('juvi_gemstones/gemstone_collection')
                         ->addFieldToFilter('status', 1);
        $gemstones->setOrder('stone_name', 'asc');
        $this->setGemstones($gemstones);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Gemstone_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'juvi_gemstones.gemstone.html.pager'
        )->setLimit(100)
        ->setCollection($this->getGemstones());
        $this->setChild('pager', $pager);
        $this->getGemstones()->load();
        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
