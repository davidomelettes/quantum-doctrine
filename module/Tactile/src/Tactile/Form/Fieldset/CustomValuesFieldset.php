<?php

namespace Tactile\Form\Fieldset;

use Tactile\Document;
use Zend\Form\Fieldset;

class CustomValuesFieldset extends Fieldset
{
    public function init()
    {
        $this->setName('customValues');
    }
    
    public function setResource(Document\Resource $resource)
    {
        foreach ($resource->getCustomFields() as $customField) {
            $fieldset = new CustomValueFieldset();
            $fieldset->setField($customField);
            $fieldset->setName($customField->getName());
            $this->add($fieldset);
        }
    }
    
}
