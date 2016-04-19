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
 * Admin search model
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Model_Adminhtml_Search_Pressarticle extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Juvi_Press_Model_Adminhtml_Search_Pressarticle
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('juvi_press/pressarticle_collection')
            ->addFieldToFilter('press_article_title', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $pressarticle) {
            $arr[] = array(
                'id'          => 'pressarticle/1/'.$pressarticle->getId(),
                'type'        => Mage::helper('juvi_press')->__('Press Article'),
                'name'        => $pressarticle->getPressArticleTitle(),
                'description' => $pressarticle->getPressArticleTitle(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/press_pressarticle/edit',
                    array('id'=>$pressarticle->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
