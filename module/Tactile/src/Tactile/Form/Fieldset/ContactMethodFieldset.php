<?php

namespace Tactile\Form\Fieldset;

use OmelettesDoctrine\Form\Fieldset\AbstractDocumentFieldset;

class ContactMethodFieldset extends AbstractDocumentFieldset
{
    public function init()
    {
        $this->setName('contactMethods');
        $this->setAttribute('class', 'contactMethod');
        $this->setLabel('Contact Method');
    }
    
    public function getHydrator()
    {
        return $this->getApplicationServiceLocator()->get('Tactile\Stdlib\Hydrator\ContactMethodHydrator');
    }
    
}
