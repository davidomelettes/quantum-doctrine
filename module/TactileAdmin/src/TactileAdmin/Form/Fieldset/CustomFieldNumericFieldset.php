<?php

namespace TactileAdmin\Form\Fieldset;

use Tactile\Document;

class CustomFieldNumericFieldset extends CustomFieldFieldset
{
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ResourceFieldNumeric');
        $this->setObject(new Document\ResourceFieldNumeric());
    
        $this->add(array(
            'name'       => 'label',
            'type'       => 'Text',
            'options'    => array(
                'label' => 'Numeric Field Label',
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
                'value' => 'n',
            ),
        ));
        
        $this->add(array(
            'name'       => 'default',
            'type'       => 'Text',
            'options'    => array(
                'label'   => 'Default Value',
            ),
            'attributes' => array(
            ),
        ));
    }
    
}
