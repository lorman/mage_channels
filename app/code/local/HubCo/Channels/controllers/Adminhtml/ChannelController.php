<?php
class HubCo_Channels_Adminhtml_ChannelController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * Instantiate our grid container block and add to the page content.
     * When accessing this admin index page, we will see a grid of all
     * brands currently available in our Magento instance, along with
     * a button to add a new one if we wish.
     */
    public function indexAction()
    {
        // instantiate the grid container
        $channelBlock = $this->getLayout()
            ->createBlock('hubco_channels_adminhtml/channel');
        // Add the grid container as the only item on this page
        $this->loadLayout();
        //var_dump(Mage::getSingleton('core/layout')->getUpdate()->getHandles());
         //die();
        $this->_addContent($channelBlock);
        $this->renderLayout();
    }
    public function editAction()
    {
      //  var_dump ($postData = $this->getRequest()->getPost('rawdata'));
      /**
      * Retrieve existing brand data if an ID was specified.
      * If not, we will have an empty brand entity ready to be populated.
      */

      $data = Mage::getModel('hubco_channels/channel');
      if ($dataId = $this->getRequest()->getParam('id', false)) {
        $data->load($dataId);
        if ($data->getId() < 1) {
          $this->_getSession()->addError(
            $this->__('This data no longer exists.')
          );
          return $this->_redirect(
            'hubco_channels_admin/channel/index'
          );
        }
      }

      // process $_POST data if the form was submitted
      if ($postData = $this->getRequest()->getPost('channel')) {
        try {
          foreach ($postData as $key => $value) {
            if (is_array($value) && !isset($_FILES['$key'])) {
              $postData[$key] = implode(',',$value);
            }
          }
          $data->addData($postData);
          $data->save();

          $this->_getSession()->addSuccess(
            $this->__("The channel has been saved.")
          );

          // redirect to remove $_POST data from the request
          return $this->_redirect(
            'hubco_channels_admin/channel/edit',
            array('id' => $data->getId())
          );
        } catch (Exception $e) {
          Mage::logException($e);
          $this->_getSession()->addError($e->getMessage());
        }

        /**
        * If we get to here, then something went wrong. Continue to
        * render the page as before, the difference this time being
        * that the submitted $_POST data is available.
        */
      }
      Mage::register('current_channel', $data);

      // Instantiate the form container.
      $dataEditBlock = $this->getLayout()->createBlock(
        'hubco_channels_adminhtml/channel_edit'
      );

      // Add the form container as the only item on this page.
      $this->loadLayout()
      ->_addContent($dataEditBlock)
      ->renderLayout();
    }

    public function deleteAction()
    {
      $brand = Mage::getModel('hubco_channels/channel');

      if ($brandId = $this->getRequest()->getParam('id', false)) {
        $brand->load($brandId);
      }

      if ($brand->getId() < 1) {
        $this->_getSession()->addError(
            $this->__('This channel no longer exists.')
        );
        return $this->_redirect(
            'hubco_channels_admin/channel/index'
        );
      }

      try {
        $brand->delete();

        $this->_getSession()->addSuccess(
            $this->__('The channel has been deleted.')
        );
      } catch (Exception $e) {
        Mage::logException($e);
        $this->_getSession()->addError($e->getMessage());
      }

      return $this->_redirect(
          'hubco_channels_admin/channel/index'
      );
    }
    /**
     * Thanks to Ben for pointing out this method was missing. Without
     * this method the ACL rules configured in adminhtml.xml are ignored.
     */
    protected function _isAllowed()
    {
        /**
         * we include this switch to demonstrate that you can add action
         * level restrictions in your ACL rules. The isAllowed() method will
         * use the ACL rule we have configured in our adminhtml.xml file:
         * - acl
         * - - resources
         * - - - admin
         * - - - - children
         * - - - - - smashingmagazine_branddirectory
         * - - - - - - children
         * - - - - - - - brand
         *
         * eg. you could add more rules inside brand for edit and delete.
         */
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
                // intentionally no break
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('hubco_channels/channel');
                break;
        }

        return $isAllowed;
    }
}