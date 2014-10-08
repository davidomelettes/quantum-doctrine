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
                'id'       => $this->getName() . '-description',
            ),
        ));
        
        $whenFieldset = $this->getServiceLocator()->get('OmelettesDoctrine\Form\Fieldset\WhenFieldset');
        $whenFieldset->setName('lastContacted')
            ->setLabel('Last Contacted');
        $this->add($whenFieldset);
        
        $contactMethodFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\ContactMethodFieldset');
        $emailFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\ContactMethodEmailFieldset');
        $faxFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\ContactMethodFaxFieldset');
        $mobileFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\ContactMethodMobileFieldset');
        $telephoneFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\ContactMethodTelephoneFieldset');
        $this->add(array(
            'type'    => 'Omelettes\Form\Element\MultiTypeCollection',
            'name'    => 'contactMethods',
            'options' => array(
                'label'                  => 'Contact Methods',
                'count'                  => 0,
                'allow_add'              => true,
                'allow_remove'           => true,
                'create_new_objects'     => true,
                'should_create_template' => true,
                'target_element'         => $contactMethodFieldset,
                'target_map'             => array(
                    'e' => $emailFieldset,
                    'f' => $faxFieldset,
                    'm' => $mobileFieldset,
                    't' => $telephoneFieldset,
                ),
                'default_type'           => 'e',
                'type_labels'            => array(
                    'e' => 'Email Address',
                    'f' => 'Fax Number',
                    'm' => 'Mobile Number',
                    't' => 'Telephone Number',
                ),
            ),
            'attributes' => array(
                'class'      => 'contactMethods',
            ),
        ));
        
        $addressFieldset = $this->getServiceLocator()->get('Tactile\Form\Fieldset\ContactAddressFieldset');
        $this->add(array(
            'type'    => 'Omelettes\Form\Element\RemovableCollection',
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
        
        $usersService = $this->getApplicationServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $userOptions = array();
        foreach ($usersService->fetchAllAccountUsers() as $user) {
            $userOptions[$user->getId()] = $user->getFullName();
        }
        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'assignedTo',
            'options' => array(
                'label'   => 'Assigned To',
                'options' => $userOptions,
            ),
            'attributes' => array(
                'id'       => $this->getName() . '-assignedTo',
                'required' => true,
            ),
        ));
        
        $this->addSubmitFieldset('Save Contact');
    }
    
}
