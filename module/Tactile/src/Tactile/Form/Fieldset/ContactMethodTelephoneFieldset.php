<?php

namespace Tactile\Form\Fieldset;

use Omelettes\Form\ViewPartialInterface;
use Tactile\Document;

class ContactMethodTelephoneFieldset extends ContactMethodFieldset implements ViewPartialInterface
{
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ContactMethodTelephone');
        $this->setObject(new Document\ContactMethodTelephone());
    
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
            'name'       => 'detail',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Telephone Number',
            ),
            'attributes' => array(
            ),
        ));
    }
    
    public function getViewPartial()
    {
        return 'form/fieldset/contact-method';
    }
}