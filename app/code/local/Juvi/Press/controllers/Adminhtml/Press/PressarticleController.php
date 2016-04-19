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
 * Press Article admin controller
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Adminhtml_Press_PressarticleController extends Juvi_Press_Controller_Adminhtml_Press
{
    /**
     * init the press article
     *
     * @access protected
     * @return Juvi_Press_Model_Pressarticle
     */
    protected function _initPressarticle()
    {
        $pressarticleId  = (int) $this->getRequest()->getParam('id');
        $pressarticle    = Mage::getModel('juvi_press/pressarticle');
        if ($pressarticleId) {
            $pressarticle->load($pressarticleId);
        }
        Mage::register('current_pressarticle', $pressarticle);
        return $pressarticle;
    }

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
        $this->_title(Mage::helper('juvi_press')->__('Press Articles'))
             ->_title(Mage::helper('juvi_press')->__('Press Articles'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit press article - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $pressarticleId    = $this->getRequest()->getParam('id');
        $pressarticle      = $this->_initPressarticle();
        if ($pressarticleId && !$pressarticle->getId()) {
            $this->_getSession()->addError(
                Mage::helper('juvi_press')->__('This press article no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getPressarticleData(true);
        if (!empty($data)) {
            $pressarticle->setData($data);
        }
        Mage::register('pressarticle_data', $pressarticle);
        $this->loadLayout();
        $this->_title(Mage::helper('juvi_press')->__('Press Articles'))
             ->_title(Mage::helper('juvi_press')->__('Press Articles'));
        if ($pressarticle->getId()) {
            $this->_title($pressarticle->getPressArticleTitle());
        } else {
            $this->_title(Mage::helper('juvi_press')->__('Add press article'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new press article action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save press article - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('pressarticle')) {
            try {
                $pressarticle = $this->_initPressarticle();
                $pressarticle->addData($data);
                $pressArticleImageName = $this->_uploadAndGetName(
                    'press_article_image',
                    Mage::helper('juvi_press/pressarticle_image')->getImageBaseDir(),
                    $data
                );
                $pressarticle->setData('press_article_image', $pressArticleImageName);
                $products = $this->getRequest()->getPost('products', -1);
                if ($products != -1) {
                    $pressarticle->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                }
                $pressarticle->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('juvi_press')->__('Press Article was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $pressarticle->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['press_article_image']['value'])) {
                    $data['press_article_image'] = $data['press_article_image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setPressarticleData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['press_article_image']['value'])) {
                    $data['press_article_image'] = $data['press_article_image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('juvi_press')->__('There was a problem saving the press article.')
                );
                Mage::getSingleton('adminhtml/session')->setPressarticleData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('juvi_press')->__('Unable to find press article to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete press article - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $pressarticle = Mage::getModel('juvi_press/pressarticle');
                $pressarticle->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('juvi_press')->__('Press Article was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('juvi_press')->__('There was an error deleting press article.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('juvi_press')->__('Could not find press article to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete press article - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $pressarticleIds = $this->getRequest()->getParam('pressarticle');
        if (!is_array($pressarticleIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('juvi_press')->__('Please select press articles to delete.')
            );
        } else {
            try {
                foreach ($pressarticleIds as $pressarticleId) {
                    $pressarticle = Mage::getModel('juvi_press/pressarticle');
                    $pressarticle->setId($pressarticleId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('juvi_press')->__('Total of %d press articles were successfully deleted.', count($pressarticleIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('juvi_press')->__('There was an error deleting press articles.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $pressarticleIds = $this->getRequest()->getParam('pressarticle');
        if (!is_array($pressarticleIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('juvi_press')->__('Please select press articles.')
            );
        } else {
            try {
                foreach ($pressarticleIds as $pressarticleId) {
                $pressarticle = Mage::getSingleton('juvi_press/pressarticle')->load($pressarticleId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d press articles were successfully updated.', count($pressarticleIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('juvi_press')->__('There was an error updating press articles.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * get grid of products action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function productsAction()
    {
        $this->_initPressarticle();
        $this->loadLayout();
        $this->getLayout()->getBlock('pressarticle.edit.tab.product')
            ->setPressarticleProducts($this->getRequest()->getPost('pressarticle_products', null));
        $this->renderLayout();
    }

    /**
     * get grid of products action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function productsgridAction()
    {
        $this->_initPressarticle();
        $this->loadLayout();
        $this->getLayout()->getBlock('pressarticle.edit.tab.product')
            ->setPressarticleProducts($this->getRequest()->getPost('pressarticle_products', null));
        $this->renderLayout();
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'pressarticle.csv';
        $content    = $this->getLayout()->createBlock('juvi_press/adminhtml_pressarticle_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'pressarticle.xls';
        $content    = $this->getLayout()->createBlock('juvi_press/adminhtml_pressarticle_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'pressarticle.xml';
        $content    = $this->getLayout()->createBlock('juvi_press/adminhtml_pressarticle_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/juvi_press/pressarticle');
    }
}
