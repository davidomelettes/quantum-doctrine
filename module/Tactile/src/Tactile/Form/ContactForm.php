<?php

namespace Tactile\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;
use OmelettesDoctrine\Form\Fieldset;

class ContactForm extends AbstractDocumentForm
{
    public function init()
    {
        $this->setName('contact');
        
        $this->add(array(
            'name' => 'fullName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label'       => "Contact's Name",
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-fullName',
                'required'    => true,
            ),
        ));
        
        $whenFieldset = $this->getServiceLocator()->get('OmelettesDoctrine\Form\Fieldset\WhenFieldset');
        $whenFieldset->setName('lastContacted')
            ->setLabel('Last Contacted')
            ->setRequired(true);
        $this->add($whenFieldset);
        
        $this->addSubmitFieldset('Save Contact');
    }
    
}
