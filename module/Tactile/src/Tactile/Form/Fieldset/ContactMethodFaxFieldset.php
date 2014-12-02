<?php

namespace Tactile\Form\Fieldset;

use Tactile\Document;

class ContactMethodFaxFieldset extends ContactMethodFieldset
{
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ContactMethodFax');
        $this->setObject(new Document\ContactMethodFax());
    
        $this->add(array(
            'name'       => 'type',
            'type'       => 'Hidden',
            'options'    => array(
            ),
            'attributes' => array(
                'value' => 'f',
            ),
        ));
    
        $this->add(array(
            'name'       => 'detail',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Fax Number',
            ),
            'attributes' => array(
            ),
        ));
    }
    
}
