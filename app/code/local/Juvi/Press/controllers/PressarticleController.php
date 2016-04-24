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
 * Press Article front contrller
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_PressarticleController extends Mage_Core_Controller_Front_Action
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
        if (Mage::helper('juvi_press/pressarticle')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('juvi_press')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'pressarticles',
                    array(
                        'label' => Mage::helper('juvi_press')->__('Press Articles'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('juvi_press/pressarticle')->getPressarticlesUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('juvi_press/pressarticle/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('juvi_press/pressarticle/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('juvi_press/pressarticle/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init Press Article
     *
     * @access protected
     * @return Juvi_Press_Model_Pressarticle
     * @author Ultimate Module Creator
     */
    protected function _initPressarticle()
    {
        $pressarticleId   = $this->getRequest()->getParam('id', 0);
        $pressarticle     = Mage::getModel('juvi_press/pressarticle')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($pressarticleId);
        if (!$pressarticle->getId()) {
            return false;
        } elseif (!$pressarticle->getStatus()) {
            return false;
        }
        return $pressarticle;
    }

    /**
     * view press article action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $pressarticle = $this->_initPressarticle();
        if (!$pressarticle) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_pressarticle', $pressarticle);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('press-pressarticle press-pressarticle' . $pressarticle->getId());
        }
        if (Mage::helper('juvi_press/pressarticle')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('juvi_press')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'pressarticles',
                    array(
                        'label' => Mage::helper('juvi_press')->__('Press Articles'),
                        'link'  => Mage::helper('juvi_press/pressarticle')->getPressarticlesUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'pressarticle',
                    array(
                        'label' => $pressarticle->getPressArticleTitle(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $pressarticle->getPressarticleUrl());
        }
        if ($headBlock) {
            if ($pressarticle->getMetaTitle()) {
                $headBlock->setTitle($pressarticle->getMetaTitle());
            } else {
                $headBlock->setTitle($pressarticle->getPressArticleTitle());
            }
            $headBlock->setKeywords($pressarticle->getMetaKeywords());
            $headBlock->setDescription($pressarticle->getMetaDescription());
        }
        $this->renderLayout();
    }
}
