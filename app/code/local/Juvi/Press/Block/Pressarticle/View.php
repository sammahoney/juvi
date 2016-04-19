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
 * Press Article view block
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Block_Pressarticle_View extends Mage_Core_Block_Template
{
    /**
     * get the current press article
     *
     * @access public
     * @return mixed (Juvi_Press_Model_Pressarticle|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentPressarticle()
    {
        return Mage::registry('current_pressarticle');
    }
}
