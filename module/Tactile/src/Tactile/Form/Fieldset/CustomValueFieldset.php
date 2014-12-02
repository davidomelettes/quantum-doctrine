<?php

namespace Tactile\Form\Fieldset;

use Tactile\Document;
use Zend\Form\Fieldset;

class CustomValueFieldset extends Fieldset
{
    public function setField(Document\ResourceField $field)
    {
        switch ($field->getType()) {
            case 't':
            default:
                $this->add(array(
                    'name'    => 'value',
                    'type'    => 'text',
                    'options' => array(
                        'label' => $field->getLabel(),
                    ),
                ));
        }
    }
    
}
