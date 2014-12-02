<?php

namespace Tactile\Form\Fieldset;

use Tactile\Document;
use Zend\Form\Fieldset;

class CustomFieldsFieldset extends Fieldset
{
    public function init()
    {
        $this->setName('custom');
    }
    
    public function setResource(Document\Resource $resource)
    {
        foreach ($resource->getCustomFields() as $customField) {
            switch ($customField->getType()) {
                default:
                    $this->add(array(
                        'name'    => $customField->getName(),
                        'type'    => 'text',
                        'options' => array(
                            'label' => $customField->getLabel(),
                        ),
                    ));
            }
        }
    }
    
}
