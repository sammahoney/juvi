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
 * Gemstone front contrller
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_GemstoneController extends Mage_Core_Controller_Front_Action
{

    /**
      * default action
      *
      * @access public
      * @return void
      * @author Ultimate Module Creator
      */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('juvi_gemstones/gemstone')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('juvi_gemstones')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'gemstones',
                    array(
                        'label' => Mage::helper('juvi_gemstones')->__('Gemstones'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('juvi_gemstones/gemstone')->getGemstonesUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('juvi_gemstones/gemstone/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('juvi_gemstones/gemstone/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('juvi_gemstones/gemstone/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init Gemstone
     *
     * @access protected
     * @return Juvi_Gemstones_Model_Gemstone
     * @author Ultimate Module Creator
     */
    protected function _initGemstone()
    {
        $gemstoneId   = $this->getRequest()->getParam('id', 0);
        $gemstone     = Mage::getModel('juvi_gemstones/gemstone')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($gemstoneId);
        if (!$gemstone->getId()) {
            return false;
        } elseif (!$gemstone->getStatus()) {
            return false;
        }
        return $gemstone;
    }

    /**
     * view gemstone action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $gemstone = $this->_initGemstone();
        if (!$gemstone) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_gemstone', $gemstone);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('gemstones-gemstone gemstones-gemstone' . $gemstone->getId());
        }
        if (Mage::helper('juvi_gemstones/gemstone')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('juvi_gemstones')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'gemstones',
                    array(
                        'label' => Mage::helper('juvi_gemstones')->__('Gemstones'),
                        'link'  => Mage::helper('juvi_gemstones/gemstone')->getGemstonesUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'gemstone',
                    array(
                        'label' => $gemstone->getStoneName(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $gemstone->getGemstoneUrl());
        }
        if ($headBlock) {
            if ($gemstone->getMetaTitle()) {
                $headBlock->setTitle($gemstone->getMetaTitle());
            } else {
                $headBlock->setTitle($gemstone->getStoneName());
            }
            $headBlock->setKeywords($gemstone->getMetaKeywords());
            $headBlock->setDescription($gemstone->getMetaDescription());
        }
        $this->renderLayout();
    }
}
