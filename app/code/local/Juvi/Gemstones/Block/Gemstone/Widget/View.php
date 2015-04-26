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
 * Gemstone widget block
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Gemstone_Widget_View extends Mage_Core_Block_Template implements
    Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'juvi_gemstones/gemstone/widget/view.phtml';

    /**
     * Prepare a for widget
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Gemstone_Widget_View
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $gemstoneId = $this->getData('gemstone_id');
        if ($gemstoneId) {
            $gemstone = Mage::getModel('juvi_gemstones/gemstone')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($gemstoneId);
            if ($gemstone->getStatus()) {
                $this->setCurrentGemstone($gemstone);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }
}
