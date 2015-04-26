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
 * Gemstone admin edit form
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Adminhtml_Gemstone_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'juvi_gemstones';
        $this->_controller = 'adminhtml_gemstone';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('juvi_gemstones')->__('Save Gemstone')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('juvi_gemstones')->__('Delete Gemstone')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('juvi_gemstones')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_gemstone') && Mage::registry('current_gemstone')->getId()) {
            return Mage::helper('juvi_gemstones')->__(
                "Edit Gemstone '%s'",
                $this->escapeHtml(Mage::registry('current_gemstone')->getStoneName())
            );
        } else {
            return Mage::helper('juvi_gemstones')->__('Add Gemstone');
        }
    }
}
