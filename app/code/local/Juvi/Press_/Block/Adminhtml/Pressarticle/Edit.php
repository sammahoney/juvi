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
 * Press Article admin edit form
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Block_Adminhtml_Pressarticle_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'juvi_press';
        $this->_controller = 'adminhtml_pressarticle';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('juvi_press')->__('Save Press Article')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('juvi_press')->__('Delete Press Article')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('juvi_press')->__('Save And Continue Edit'),
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
        if (Mage::registry('current_pressarticle') && Mage::registry('current_pressarticle')->getId()) {
            return Mage::helper('juvi_press')->__(
                "Edit Press Article '%s'",
                $this->escapeHtml(Mage::registry('current_pressarticle')->getPressArticleTitle())
            );
        } else {
            return Mage::helper('juvi_press')->__('Add Press Article');
        }
    }
}
