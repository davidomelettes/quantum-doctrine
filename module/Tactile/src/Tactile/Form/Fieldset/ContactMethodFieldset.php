<?php

namespace Tactile\Form\Fieldset;

use Omelettes\Form\ViewPartialInterface;
use OmelettesDoctrine\Form\Fieldset\AbstractDocumentFieldset;
use Tactile\Document;

class ContactMethodFieldset extends AbstractDocumentFieldset implements ViewPartialInterface
{
    public function init()
    {
        $this->setName('contactMethods');
        $this->setAttribute('class', 'contactMethod');
        $this->setAllowedObjectBindingClass('Tactile\Document\ContactMethod');
        $this->setObject(new Document\ContactMethod());
        
        $method = new Document\ContactMethod();
        $this->add(array(
            'name'       => 'type',
            'type'       => 'Select',
            'options'    => array(
                'label'         => 'Type',
                'value_options' => $method->getTypes(),
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name'       => 'detail',
            'type'       => 'Text',
            'options'    => array(
                'label'         => 'Detail',
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
