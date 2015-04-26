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
 * Gemstone image field renderer helper
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Adminhtml_Gemstone_Helper_Image extends Varien_Data_Form_Element_Image
{
    /**
     * get the url of the image
     *
     * @access protected
     * @return string
     * @author Ultimate Module Creator
     */
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = Mage::helper('juvi_gemstones/gemstone_image')->getImageBaseUrl().
                $this->getValue();
        }
        return $url;
    }
}
