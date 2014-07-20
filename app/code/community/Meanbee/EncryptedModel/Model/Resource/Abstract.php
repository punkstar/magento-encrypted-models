<?php

/**
 * Class Meanbee_EncryptedModel_Model_Resource_Abstract
 */
abstract class Meanbee_EncryptedModel_Model_Resource_Abstract extends Mage_Core_Model_Resource_Db_Abstract {

    /**
     * @return array
     */
    abstract protected function _getEncryptedFields();

    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this|Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        parent::_afterLoad($object);

        Mage::helper('meanbee_encryptedmodel')->decryptObject($object, $this->_getEncryptedFields());

        return $this;
    }

    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object) {

        Mage::helper('meanbee_encryptedmodel')->encryptObject($object, $this->_getEncryptedFields());

        return parent::_beforeSave($object);
    }

    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this|Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        parent::_afterSave($object);

        Mage::helper('meanbee_encryptedmodel')->decryptObject($object, $this->_getEncryptedFields());

        return $this;
    }
}
