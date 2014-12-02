<?php

namespace Tactile\Form\Fieldset;

use Tactile\Document;

class ContactMethodMobileFieldset extends ContactMethodFieldset
{
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ContactMethodMobile');
        $this->setObject(new Document\ContactMethodMobile());
    
        $this->add(array(
            'name'       => 'type',
            'type'       => 'Hidden',
            'options'    => array(
            ),
            'attributes' => array(
                'value' => 'm',
            ),
        ));
    
        $this->add(array(
            'name'       => 'detail',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Mobile Number',
            ),
            'attributes' => array(
            ),
        ));
    }
    
}
