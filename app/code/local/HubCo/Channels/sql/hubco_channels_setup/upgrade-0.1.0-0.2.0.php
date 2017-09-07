<?php

$this->startSetup();

$this->getConnection()
    ->addColumn($this->getTable('hubco_channels/channel'),
    'store_view',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 256,
        'nullable' => true,
        'default' => null,
        'comment' => 'Store Views for Channel'
    )
);

$this->endSetup();
?>