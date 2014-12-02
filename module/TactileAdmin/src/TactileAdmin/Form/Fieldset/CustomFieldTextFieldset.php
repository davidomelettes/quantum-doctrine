<?php

namespace TactileAdmin\Form\Fieldset;

use Tactile\Document;

class CustomFieldTextFieldset extends CustomFieldFieldset
{
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ResourceFieldText');
        $this->setObject(new Document\ResourceFieldText());
    
        $this->add(array(
            'name'       => 'label',
            'type'       => 'Text',
            'options'    => array(
                'label' => 'Text Field Label',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name'       => 'type',
            'type'       => 'Hidden',
            'options'    => array(
            ),
            'attributes' => array(
                'value' => 't',
            ),
        ));
        
        $this->add(array(
            'name'       => 'default',
            'type'       => 'Text',
            'options'    => array(
                'label' => 'Default Value',
            ),
            'attributes' => array(
            ),
        ));
    }
    
}
