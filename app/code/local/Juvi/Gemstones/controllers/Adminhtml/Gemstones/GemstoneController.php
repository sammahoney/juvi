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
 * Gemstone admin controller
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Adminhtml_Gemstones_GemstoneController extends Juvi_Gemstones_Controller_Adminhtml_Gemstones
{
    /**
     * init the gemstone
     *
     * @access protected
     * @return Juvi_Gemstones_Model_Gemstone
     */
    protected function _initGemstone()
    {
        $gemstoneId  = (int) $this->getRequest()->getParam('id');
        $gemstone    = Mage::getModel('juvi_gemstones/gemstone');
        if ($gemstoneId) {
            $gemstone->load($gemstoneId);
        }
        Mage::register('current_gemstone', $gemstone);
        return $gemstone;
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
        $this->_title(Mage::helper('juvi_gemstones')->__('Gemstones'))
             ->_title(Mage::helper('juvi_gemstones')->__('Gemstones'));
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
     * edit gemstone - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $gemstoneId    = $this->getRequest()->getParam('id');
        $gemstone      = $this->_initGemstone();
        if ($gemstoneId && !$gemstone->getId()) {
            $this->_getSession()->addError(
                Mage::helper('juvi_gemstones')->__('This gemstone no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getGemstoneData(true);
        if (!empty($data)) {
            $gemstone->setData($data);
        }
        Mage::register('gemstone_data', $gemstone);
        $this->loadLayout();
        $this->_title(Mage::helper('juvi_gemstones')->__('Gemstones'))
             ->_title(Mage::helper('juvi_gemstones')->__('Gemstones'));
        if ($gemstone->getId()) {
            $this->_title($gemstone->getStoneName());
        } else {
            $this->_title(Mage::helper('juvi_gemstones')->__('Add gemstone'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new gemstone action
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
     * save gemstone - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('gemstone')) {
            try {
                $gemstone = $this->_initGemstone();
                $gemstone->addData($data);
                $stoneImageName = $this->_uploadAndGetName(
                    'stone_image',
                    Mage::helper('juvi_gemstones/gemstone_image')->getImageBaseDir(),
                    $data
                );
                $gemstone->setData('stone_image', $stoneImageName);
                $products = $this->getRequest()->getPost('products', -1);
                if ($products != -1) {
                    $gemstone->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                }
                $gemstone->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('juvi_gemstones')->__('Gemstone was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $gemstone->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['stone_image']['value'])) {
                    $data['stone_image'] = $data['stone_image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setGemstoneData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['stone_image']['value'])) {
                    $data['stone_image'] = $data['stone_image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('juvi_gemstones')->__('There was a problem saving the gemstone.')
                );
                Mage::getSingleton('adminhtml/session')->setGemstoneData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('juvi_gemstones')->__('Unable to find gemstone to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete gemstone - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $gemstone = Mage::getModel('juvi_gemstones/gemstone');
                $gemstone->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('juvi_gemstones')->__('Gemstone was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('juvi_gemstones')->__('There was an error deleting gemstone.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('juvi_gemstones')->__('Could not find gemstone to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete gemstone - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $gemstoneIds = $this->getRequest()->getParam('gemstone');
        if (!is_array($gemstoneIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('juvi_gemstones')->__('Please select gemstones to delete.')
            );
        } else {
            try {
                foreach ($gemstoneIds as $gemstoneId) {
                    $gemstone = Mage::getModel('juvi_gemstones/gemstone');
                    $gemstone->setId($gemstoneId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('juvi_gemstones')->__('Total of %d gemstones were successfully deleted.', count($gemstoneIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('juvi_gemstones')->__('There was an error deleting gemstones.')
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
        $gemstoneIds = $this->getRequest()->getParam('gemstone');
        if (!is_array($gemstoneIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('juvi_gemstones')->__('Please select gemstones.')
            );
        } else {
            try {
                foreach ($gemstoneIds as $gemstoneId) {
                $gemstone = Mage::getSingleton('juvi_gemstones/gemstone')->load($gemstoneId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d gemstones were successfully updated.', count($gemstoneIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('juvi_gemstones')->__('There was an error updating gemstones.')
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
        $this->_initGemstone();
        $this->loadLayout();
        $this->getLayout()->getBlock('gemstone.edit.tab.product')
            ->setGemstoneProducts($this->getRequest()->getPost('gemstone_products', null));
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
        $this->_initGemstone();
        $this->loadLayout();
        $this->getLayout()->getBlock('gemstone.edit.tab.product')
            ->setGemstoneProducts($this->getRequest()->getPost('gemstone_products', null));
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
        $fileName   = 'gemstone.csv';
        $content    = $this->getLayout()->createBlock('juvi_gemstones/adminhtml_gemstone_grid')
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
        $fileName   = 'gemstone.xls';
        $content    = $this->getLayout()->createBlock('juvi_gemstones/adminhtml_gemstone_grid')
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
        $fileName   = 'gemstone.xml';
        $content    = $this->getLayout()->createBlock('juvi_gemstones/adminhtml_gemstone_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('cms/juvi_gemstones/gemstone');
    }
}
