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
        
        $whenFieldset = new Fieldset\WhenFieldset('lastContacted', 'Last Contacted', true);
        $this->add($whenFieldset);
        //$dateFieldset = new Fieldset\DateTimeFieldset('lastContacted', 'Last Contacted');
        //$this->add($dateFieldset);
        /*
        $this->add(array(
            'name' => 'lastContacted',
            'type' => 'Omelettes\Form\Element\DateTimeCompatible',
            'options' => array(
                'label'       => 'Last Contacted',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-lastContacted',
                'required'    => true,
            ),
        ));
        */
        
        $this->addSubmitFieldset('Save Contact');
    }
}
