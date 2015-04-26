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
 * Gemstone view block
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Gemstone_View extends Mage_Core_Block_Template
{
    /**
     * get the current gemstone
     *
     * @access public
     * @return mixed (Juvi_Gemstones_Model_Gemstone|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentGemstone()
    {
        return Mage::registry('current_gemstone');
    }
}
