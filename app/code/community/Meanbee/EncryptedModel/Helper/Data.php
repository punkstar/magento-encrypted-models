<?php

class Meanbee_EncryptedModel_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * @param Varien_Object $object
     * @param array $encrypted_fields
     *
     * @return Varien_Object
     */
    public function decryptObject(Varien_Object $object, array $encrypted_fields) {
        foreach ($encrypted_fields as $field_name) {
            $raw_value = $object->getData($field_name);

            if ($raw_value == null) {
                continue;
            }

            if (!is_scalar($raw_value)) {
                Mage::throwException(sprintf("%s: Unable to decrypt %s, value was not scalar.", __CLASS__, $field_name));
            }

            $object->setData($field_name, Mage::helper('core')->decrypt($raw_value));
        }

        return $object;
    }

    /**
     * @param Varien_Object $object
     * @param array $encrypted_fields
     *
     * @return Varien_Object
     */
    public function encryptObject(Varien_Object $object, array $encrypted_fields) {
        foreach ($encrypted_fields as $field_name) {
            $raw_value = $object->getData($field_name);

            if ($raw_value == null) {
                continue;
            }

            if (!is_scalar($raw_value)) {
                Mage::throwException(sprintf("%s: Unable to encrypt %s, value was not scalar.", __CLASS__, $field_name));
            }

            $object->setData($field_name, Mage::helper('core')->encrypt($raw_value));
        }

        return $object;
    }
}
