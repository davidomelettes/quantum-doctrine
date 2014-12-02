<?php

namespace Tactile\Form\Fieldset;

use Omelettes\Form\ViewPartialInterface;
use OmelettesDoctrine\Form\Fieldset\AbstractDocumentFieldset;

class ContactMethodFieldset extends AbstractDocumentFieldset implements ViewPartialInterface
{
    public function init()
    {
        $this->setName('contactMethods');
        $this->setAttribute('class', 'contactMethod');
        $this->setLabel('Contact Method');
    }
    
    public function getHydrator()
    {
        return $this->getApplicationServiceLocator()->get('Tactile\Stdlib\Hydrator\MultiTypeCollectionHydrator');
    }
    
    public function getViewPartial()
    {
        return 'form/fieldset/contact-method';
    }
    
}
