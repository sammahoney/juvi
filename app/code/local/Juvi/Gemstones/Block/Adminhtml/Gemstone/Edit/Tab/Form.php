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
 * Gemstone edit form tab
 *
 * @category    Juvi
 * @package     Juvi_Gemstones
 * @author      Ultimate Module Creator
 */
class Juvi_Gemstones_Block_Adminhtml_Gemstone_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Juvi_Gemstones_Block_Adminhtml_Gemstone_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('gemstone_');
        $form->setFieldNameSuffix('gemstone');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'gemstone_form',
            array('legend' => Mage::helper('juvi_gemstones')->__('Gemstone'))
        );
        $fieldset->addType(
            'image',
            Mage::getConfig()->getBlockClassName('juvi_gemstones/adminhtml_gemstone_helper_image')
        );

        $fieldset->addField(
            'stone_name',
            'text',
            array(
                'label' => Mage::helper('juvi_gemstones')->__('Stone Name'),
                'name'  => 'stone_name',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'stone_origin',
            'text',
            array(
                'label' => Mage::helper('juvi_gemstones')->__('Stone Origin'),
                'name'  => 'stone_origin',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'stone_description',
            'textarea',
            array(
                'label' => Mage::helper('juvi_gemstones')->__('Stone Description'),
                'name'  => 'stone_description',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'stone_image',
            'image',
            array(
                'label' => Mage::helper('juvi_gemstones')->__('Stone Image'),
                'name'  => 'stone_image',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('juvi_gemstones')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('juvi_gemstones')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('juvi_gemstones')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('juvi_gemstones')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('juvi_gemstones')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_gemstone')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getGemstoneData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getGemstoneData());
            Mage::getSingleton('adminhtml/session')->setGemstoneData(null);
        } elseif (Mage::registry('current_gemstone')) {
            $formValues = array_merge($formValues, Mage::registry('current_gemstone')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
