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
            'name'       => 'fullName',
            'type'       => 'Zend\Form\Element\Text',
            'options'    => array(
                'label'    => "Contact's Name",
            ),
            'attributes' => array(
                'id'       => $this->getName() . '-fullName',
                'required' => true,
            ),
        ));
        
        $this->add(array(
            'name'       => 'description',
            'type'       => 'Zend\Form\Element\Textarea',
            'options'    => array(
                'label'   => "Description",
            ),
            'attributes' => array(
                'id'      => $this->getName() . '-description',
            ),
        ));
        
        $whenFieldset = $this->getServiceLocator()->get('OmelettesDoctrine\Form\Fieldset\WhenFieldset');
        $whenFieldset->setName('lastContacted')
            ->setLabel('Last Contacted');
        $this->add($whenFieldset);
        
        $contactMethodFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\ContactMethodFieldset');
        $this->add(array(
            'type'    => 'Zend\Form\Element\Collection',
            'name'    => 'contactMethods',
            'options' => array(
                'label'                  => 'Contact Methods',
                'count'                  => 0,
                'allow_add'              => true,
                'allow_remove'           => true,
                'create_new_objects'     => true,
                'should_create_template' => true,
                'target_element'         => $contactMethodFieldset,
            ),
            'attributes' => array(
                'class'      => 'contactMethods',
            ),
        ));
        
        $addressFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\ContactAddressFieldset');
        $this->add(array(
            'type'    => 'Zend\Form\Element\Collection',
            'name'    => 'addresses',
            'options' => array(
                'label'                  => 'Addresses',
                'count'                  => 0,
                'allow_add'              => true,
                'allow_remove'           => true,
                'create_new_objects'     => true,
                'should_create_template' => true,
                'target_element'         => $addressFieldset,
            ),
            'attributes' => array(
                'class'      => 'addresses',
            ),
        ));
        
        $this->addSubmitFieldset('Save Contact');
    }
    
}
