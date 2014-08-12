<?php

namespace Tactile\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;

class ContactForm extends AbstractDocumentForm
{
    public function init()
    {
        $this->add(array(
            'name' => 'fullName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => "Contact's Name",
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-password',
                'required'    => true,
            ),
        ));
        
        $this->addSubmitFieldset('Save Contact');
    }
}
