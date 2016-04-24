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
 * Press Article widget block
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Block_Pressarticle_Widget_View extends Mage_Core_Block_Template implements
    Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'juvi_press/pressarticle/widget/view.phtml';

    /**
     * Prepare a for widget
     *
     * @access protected
     * @return Juvi_Press_Block_Pressarticle_Widget_View
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $pressarticleId = $this->getData('pressarticle_id');
        if ($pressarticleId) {
            $pressarticle = Mage::getModel('juvi_press/pressarticle')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($pressarticleId);
            if ($pressarticle->getStatus()) {
                $this->setCurrentPressarticle($pressarticle);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }
}
