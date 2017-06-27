<?php

/**
 * Rawdata edit form
 *
 * @category    HubCo
 * @package     HubCo_Manual
 * @author      Ultimate Module Creator
 */
class HubCo_Channels_Block_Adminhtml_Channel_Edit_Form
extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     *
     * @access protected
     * @return HubCo_Manual_Block_Adminhtml_Rawdata_Edit_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {

      $form = new Varien_Data_Form(array(
          'id' => 'edit_form',
          'action' => $this->getUrl(
              'hubco_channels_admin/channel/edit',
              array(
                  '_current' => true,
                  'continue' => 0,
              )
          ),
          'method' => 'post',
          'enctype' => 'multipart/form-data'
      ));

      $form->setUseContainer(true);  // very importent line :)

      $form->setHtmlIdPrefix('channel_');
      $form->setFieldNameSuffix('channel');
      $this->setForm($form);
      $fieldset = $form->addFieldset(
          'channel_form',
          array('legend' => Mage::helper('hubco_channels')->__('Channel'))
      );

      $fieldset->addField(
          'name',
          'text',
          array(
              'label' => Mage::helper('hubco_channels')->__('Name'),
              'name'  => 'name',

         )
      );

      $fieldset->addField(
          'fee',
          'text',
          array(
              'label' => Mage::helper('hubco_channels')->__('Fee'),
              'name'  => 'fee',

         )
      );
      $fieldset->addField(
          'margin',
          'text',
          array(
              'label' => Mage::helper('hubco_channels')->__('Margin'),
              'name'  => 'margin',

          )
      );
      $fieldset->addField(
          'ship_threshold',
          'text',
          array(
              'label' => Mage::helper('hubco_channels')->__('Free Shipping Threshold'),
              'name'  => 'ship_threshold',

          )
      );

      $fieldset->addField(
          'chan_attr_price',
          'text',
          array(
              'label' => Mage::helper('hubco_channels')->__('Channel Price Attribute'),
              'name'  => 'chan_attr_price',

         )
      );

      $fieldset->addField(
          'chan_attr_allowed',
          'text',
          array(
              'label' => Mage::helper('hubco_channels')->__('Channel Allowed Attribute'),
              'name'  => 'chan_attr_allowed',

         )
      );
      $formValues = Mage::registry('current_channel')->getDefaultValues();
      if (!is_array($formValues)) {
         $formValues = array();
      }
      if (Mage::getSingleton('adminhtml/session')->getChannelData()) {
          $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getChannelData());
          Mage::getSingleton('adminhtml/session')->setChannelData(null);
      } elseif (Mage::registry('current_channel')) {
          $formValues = array_merge($formValues, Mage::registry('current_channel')->getData());
      }
      $form->setValues($formValues);

      return parent::_prepareForm();
    }
}
