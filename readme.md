#Transparent Field Encryption for Magento Models

Magento has oft-underused inbuilt methods for encrypting and decrypting data avaiable on the core helper.  This extension allows an extension developer to define the fields on their models that they'd like to secure while the data is in the database database, without having to change how they interact with their model and collection.

##Installation

    modman clone git@github.com:punkstar/magento-encrypted-models.git
    modman deploy magento-encrypted-models
    
##Usage

The extension defines two classes:

* `Meanbee_EncryptedModel_Model_Resource_Abstract`
* `Meanbee_EncryptedModel_Model_Resource_Collection_Abstract`

Use these two classes to create your *resource model* and *collection* for your model.  You'll notice they are `abstract` and require implementation of a method called `_getEncryptedFields`.  This method should return an `array` containing the data fields that you would like to secure.

##Example

For example, assuming I had an extension that stored pineapples (I challenge you to come up with a better example) in the database, and I needed the weight of the pineapple encrypted while it was stored in the database.  My *model*, *resource model* and *collection* classes would look like this:
	
	/**
	 * Model
	 */
    class Nick_Fruit_Model_Pineapple extends Mage_Core_Model_Abstract {
        ...
    }

	/**
	 * Resource Model
	 */
    class Nick_Fruit_Model_Resource_Pineapple extends Meanbee_EncryptedModel_Model_Resource_Abstract {
        ...
        
        protected function _getEncryptedFields() {
            return array(
                'weight'
            );
        }
        
        ...
    }
    
    /**
     * Collection
     */
    class Nick_Fruit_Model_Resource_Pineapple_Collection extends Meanbee_EncryptedModel_Model_Resource_Collection_Abstract {
        ...
        
        protected function _getEncryptedFields() {
            return array(
                'weight'
            );
        }
        
        ...
    }
    
Interacting with your models doesn't change.

	/*
	 * Creating
	 */
    $pineapple = Mage::getModel('nick_fruit/pineapple);
    $pineapple->setName('Billy')
              ->setAge(45)
              ->setWeight(200);
    
    echo $pineapple->getWeight(); // 200
    $pineapple->save();
    echo $pineapple->getWeight(); // 200
    
    /*
     * Reading
     */
    $pineapple->load(1);
    echo $pineapple->getWeight(); // 200
    
    /*
     * Reading from a collection.
     */
    $pineapples = Mage::getModel('nick_fruit/pineapple')->getCollection()
    	->addFieldToFilter('name', 'Billy');
    
    foreach ($pineapples as $pineapple) {
	    echo $pineapple->getWeight(); // 200
    }
            
The process is entirely transparent.

##How it works

By defining the *resource model* and the *collection* of your models to be under this extension's control, it allows us to easily tap into the `_beforeSave`, `_afterSave` and `_afterLoad` methods on them.

##Future work

* Can we do this exclusively through events?  Probably.
* Can we define the attributes we'd like to encrypt in the XML? Probably.
* Get some tests in. Should have done that already, sorry.
* Implement as a trait instead?