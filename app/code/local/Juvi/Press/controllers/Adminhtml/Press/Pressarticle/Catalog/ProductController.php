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
 * Press Article - product controller
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class Juvi_Press_Adminhtml_Press_Pressarticle_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    /**
     * construct
     *
     * @access protected
     * @return void
     * @author Ultimate Module Creator
     */
    protected function _construct()
    {
        // Define module dependent translate
        $this->setUsedModuleName('Juvi_Press');
    }

    /**
     * press articles in the catalog page
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function pressarticlesAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('product.edit.tab.pressarticle')
            ->setProductPressarticles($this->getRequest()->getPost('product_pressarticles', null));
        $this->renderLayout();
    }

    /**
     * press articles grid in the catalog page
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function pressarticlesGridAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('product.edit.tab.pressarticle')
            ->setProductPressarticles($this->getRequest()->getPost('product_pressarticles', null));
        $this->renderLayout();
    }
}
