<?php

abstract class Meanbee_EncryptedModel_Model_Resource_Collection_Abstract extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    /**
     * @return $this|Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected function _afterLoad() {
        parent::_afterLoad();

        foreach ($this->getItems() as $item) {
            Mage::helper('meanbee_encryptedmodel')->decryptObject($item, $this->getResource()->getEncryptedFields());
        }

        return $this;
    }
}
