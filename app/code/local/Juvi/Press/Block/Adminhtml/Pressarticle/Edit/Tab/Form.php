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
 * Press Article edit form tab
 *
 * @category    Juvi
 * @package     Juvi_Press
 * @author      Ultimate Module Creator
 */
class Juvi_Press_Block_Adminhtml_Pressarticle_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Juvi_Press_Block_Adminhtml_Pressarticle_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('pressarticle_');
        $form->setFieldNameSuffix('pressarticle');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'pressarticle_form',
            array('legend' => Mage::helper('juvi_press')->__('Press Article'))
        );
        $fieldset->addType(
            'image',
            Mage::getConfig()->getBlockClassName('juvi_press/adminhtml_pressarticle_helper_image')
        );

        $fieldset->addField(
            'press_article_title',
            'text',
            array(
                'label' => Mage::helper('juvi_press')->__('Press Article Title'),
                'name'  => 'press_article_title',
            'note'	=> $this->__('Will display on detail page only'),
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'press_article_origin_date',
            'text',
            array(
                'label' => Mage::helper('juvi_press')->__('Press Article Origin / Date'),
                'name'  => 'press_article_origin_date',
            'note'	=> $this->__('For example: RSVP Magazine, April 2016'),
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'press_article_description',
            'textarea',
            array(
                'label' => Mage::helper('juvi_press')->__('Press Article Description'),
                'name'  => 'press_article_description',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'press_article_image',
            'image',
            array(
                'label' => Mage::helper('juvi_press')->__('Press Article Image'),
                'name'  => 'press_article_image',
            'note'	=> $this->__('Dimensions should be 1000px wide by 1400px tall'),

           )
        );

        $fieldset->addField(
            'press_article_image2',
            'image',
            array(
                'label' => Mage::helper('juvi_press')->__('Press Article Image 2'),
                'name'  => 'press_article_image2',
            'note'	=> $this->__('Dimensions should be 1000px wide by 1400px tall'),

           )
        );

        $fieldset->addField(
            'press_article_image3',
            'image',
            array(
                'label' => Mage::helper('juvi_press')->__('Press Article Image 3'),
                'name'  => 'press_article_image3',
            'note'	=> $this->__('Dimensions should be 1000px wide by 1400px tall'),

           )
        );

        $fieldset->addField(
            'press_article_image4',
            'image',
            array(
                'label' => Mage::helper('juvi_press')->__('Press Article Image 4'),
                'name'  => 'press_article_image4',
            'note'	=> $this->__('Dimensions should be 1000px wide by 1400px tall'),

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('juvi_press')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('juvi_press')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('juvi_press')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('juvi_press')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('juvi_press')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_pressarticle')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getPressarticleData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getPressarticleData());
            Mage::getSingleton('adminhtml/session')->setPressarticleData(null);
        } elseif (Mage::registry('current_pressarticle')) {
            $formValues = array_merge($formValues, Mage::registry('current_pressarticle')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
