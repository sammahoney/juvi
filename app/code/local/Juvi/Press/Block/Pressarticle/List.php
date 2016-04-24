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
 * Press Article list block
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author Ultimate Module Creator
 */
class Juvi_Press_Block_Pressarticle_List extends Mage_Core_Block_Template
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
        $pressarticles = Mage::getResourceModel('juvi_press/pressarticle_collection')
                         ->addFieldToFilter('status', 1);
        $pressarticles->setOrder('entity_id', 'desc');
        $this->setPressarticles($pressarticles);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return Juvi_Press_Block_Pressarticle_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'juvi_press.pressarticle.html.pager'
        )
        ->setCollection($this->getPressarticles());
        $this->setChild('pager', $pager);
        $this->getPressarticles()->load();
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
