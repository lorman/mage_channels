<?php
class HubCo_Channels_Block_Adminhtml_Channel_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        /**
         * Tell Magento which collection to use to display in the grid.
         */
        $collection = Mage::getResourceModel(
            'hubco_channels/channel_collection'
        );
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function getRowUrl($row)
    {
        /**
         * When a grid row is clicked, this is where the user should
         * be redirected to - in our example, the method editAction of
         * BrandController.php in BrandDirectory module.
         */
      return $this->getUrl(
            'hubco_channels_admin/channel/edit',
            array(
                'id' => $row->getId()
            )
        );
    }

    protected function _prepareColumns()
    {
        /**
         * Here, we'll define which columns to display in the grid.
         */
        $this->addColumn('channel_id', array(
            'header' => $this->_getHelper()->__('Channel ID'),
            'type' => 'text',
            'index' => 'channel_id',
        ));

        $this->addColumn('name', array(
            'header' => $this->_getHelper()->__('Channel name'),
            'type' => 'text',
            'index' => 'name',
        ));

        $this->addColumn('fee', array(
            'header' => $this->_getHelper()->__('Channel fee'),
            'type' => 'text',
            'index' => 'fee',
        ));

        $this->addColumn('margin', array(
            'header' => $this->_getHelper()->__('Channel margin'),
            'type' => 'text',
            'index' => 'margin',
        ));
        $this->addColumn('ship_threshold', array(
            'header' => $this->_getHelper()->__('FreeShip Threshold'),
            'type' => 'text',
            'index' => 'ship_threshold',
        ));

        $this->addColumn('chan_attr_price', array(
            'header' => $this->_getHelper()->__('Channel Price Attribute'),
            'type' => 'text',
            'index' => 'chan_attr_price',
        ));

        $this->addColumn('chan_attr_allowed', array(
            'header' => $this->_getHelper()->__('Channel Allowed Attribute'),
            'type' => 'text',
            'index' => 'chan_attr_allowed',
        ));

        $this->addColumn('store_view', array(
            'header' => $this->_getHelper()->__('Store Views'),
            'type' => 'text',
            'index' => 'store_view',
        ));
        return parent::_prepareColumns();
    }

    protected function _getHelper()
    {
        return Mage::helper('hubco_channels');
    }
}