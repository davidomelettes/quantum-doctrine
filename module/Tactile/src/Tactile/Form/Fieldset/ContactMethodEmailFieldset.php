<?php

namespace Tactile\Form\Fieldset;

use Omelettes\Form\ViewPartialInterface;
use Tactile\Document;

class ContactMethodEmailFieldset extends ContactMethodFieldset implements ViewPartialInterface
{
    protected function extract()
    {
        //var_dump('ex!');
        return parent::extract();
    }
    
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ContactMethodEmail');
        $this->setObject(new Document\ContactMethodEmail());
    
        $this->add(array(
            'name'       => 'type',
            'type'       => 'Hidden',
            'options'    => array(
            ),
            'attributes' => array(
                'value' => 'e',
            ),
        ));
    
        $this->add(array(
            'name'       => 'detail',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Email Address',
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