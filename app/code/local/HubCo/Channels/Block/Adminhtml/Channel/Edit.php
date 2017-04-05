<?php

/**
 * RawData admin edit form
 *
 * @category    HubCo
 * @package     HubCo_Manual
 * @author      Ultimate Module Creator
 */
class HubCo_Channels_Block_Adminhtml_Channel_Edit
extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'hubco_channels';
        $this->_controller = 'adminhtml_channel';
         $this->_updateButton(
             'save',
             'label',
             Mage::helper('hubco_channels')->__('Save Channel')
         );
        $this->_updateButton(
             'delete',
             'label',
             Mage::helper('hubco_channels')->__('Delete Channel')
         );
         $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('hubco_channels')->__('Save And Continue Edit'),
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


              if (Mage::registry('current_channel') && Mage::registry('current_channel')->getId()) {
            return Mage::helper('hubco_channels')->__(
                "Edit Channel '%s'",
                $this->escapeHtml(Mage::registry('current_channel')->getSupplierId())
            );
        } else {
            return Mage::helper('hubco_channels')->__('Add Channel');
        }
    }
}
