<?php
class HubCo_Channels_Model_Channel
    extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        /**
         * This tells Magento where the related resource model can be found.
         *
         * For a resource model, Magento will use the standard model alias -
         * in this case 'hubco_brand' - and look in
         * config.xml for a child node <resourceModel/>. This will be the
         * location that Magento will look for a model when
         * Mage::getResourceModel() is called - in our case,
         * HubCo_Brand_Model_Resource.
         */
        $this->_init('hubco_channels/channel');
    }

    public function toOptionList($multi = false)
    {
      $channels = array();
      $allChannelsCollection = Mage::getModel('hubco_channels/channel')
      ->getCollection();
      $allChannels = $allChannelsCollection->load()->toArray();
      $allChannels['items'][] = array('name'=>'NONE','channel_id' => -1);
      foreach ($allChannels['items'] as $channel)
      {
        if (!isset($channel['name'])) {
          continue;
        }
        if ($multi)
        {
          $channels[$channel['channel_id']] = array(
              'value' => $channel['channel_id'],
              'label' => $channel['name']
          );
        }
        else
        {
          $channels[$channel['channel_id']] = $channel['name'];
        }
      }

      return $channels;
    }

    public function getByStoreViewCode($code) {
      $channelCollection = Mage::getModel('hubco_channels/channel')->getCollection();
      $channelCollection->addFieldToFilter(
          'store_view',$code);
      //echo $channelCollection->getSelect()->__toString();
      $channels = $channelCollection->getData();
      return $channels;

    }
}